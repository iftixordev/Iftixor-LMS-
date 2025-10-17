<!-- Drag & Drop File Upload -->
<div class="file-upload-zone" id="fileUploadZone">
    <div class="upload-content">
        <i class="fas fa-cloud-upload-alt upload-icon"></i>
        <h3>Fayllarni bu yerga tashlang</h3>
        <p>yoki <button type="button" class="upload-btn" onclick="document.getElementById('fileInput').click()">faylni tanlang</button></p>
        <input type="file" id="fileInput" multiple hidden>
    </div>
    <div class="upload-progress" id="uploadProgress" style="display: none;">
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
        <span id="progressText">0%</span>
    </div>
</div>

<div id="fileList" class="file-list"></div>

<script>
class FileUploader {
    constructor(zoneId, inputId) {
        this.zone = document.getElementById(zoneId);
        this.input = document.getElementById(inputId);
        this.files = [];
        this.init();
    }

    init() {
        // Drag & Drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this.zone.addEventListener(eventName, this.preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            this.zone.addEventListener(eventName, () => this.zone.classList.add('drag-over'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            this.zone.addEventListener(eventName, () => this.zone.classList.remove('drag-over'), false);
        });

        this.zone.addEventListener('drop', this.handleDrop.bind(this), false);
        this.input.addEventListener('change', this.handleFiles.bind(this), false);
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        this.handleFiles({ target: { files } });
    }

    handleFiles(e) {
        const files = [...e.target.files];
        files.forEach(this.addFile.bind(this));
        this.uploadFiles();
    }

    addFile(file) {
        this.files.push(file);
        this.displayFile(file);
    }

    displayFile(file) {
        const fileList = document.getElementById('fileList');
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        fileItem.innerHTML = `
            <div class="file-info">
                <i class="fas ${this.getFileIcon(file.type)}"></i>
                <div>
                    <div class="file-name">${file.name}</div>
                    <div class="file-size">${this.formatFileSize(file.size)}</div>
                </div>
            </div>
            <div class="file-status">
                <i class="fas fa-clock text-warning"></i>
            </div>
        `;
        fileList.appendChild(fileItem);
    }

    getFileIcon(type) {
        if (type.startsWith('image/')) return 'fa-image';
        if (type.includes('pdf')) return 'fa-file-pdf';
        if (type.includes('word')) return 'fa-file-word';
        if (type.includes('excel')) return 'fa-file-excel';
        return 'fa-file';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    async uploadFiles() {
        const formData = new FormData();
        this.files.forEach(file => formData.append('files[]', file));

        const progressBar = document.getElementById('uploadProgress');
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');

        progressBar.style.display = 'block';

        try {
            const response = await fetch('/admin/files/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                onUploadProgress: (progressEvent) => {
                    const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressFill.style.width = percentCompleted + '%';
                    progressText.textContent = percentCompleted + '%';
                }
            });

            if (response.ok) {
                notifications.show('Fayllar muvaffaqiyatli yuklandi!', 'success');
                this.files = [];
                document.getElementById('fileList').innerHTML = '';
            } else {
                throw new Error('Upload failed');
            }
        } catch (error) {
            notifications.show('Fayl yuklashda xatolik!', 'error');
        } finally {
            progressBar.style.display = 'none';
        }
    }
}

// Initialize uploader
const uploader = new FileUploader('fileUploadZone', 'fileInput');
</script>

<style>
.file-upload-zone {
    border: 2px dashed var(--gemini-border);
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    background: var(--gemini-surface);
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-zone.drag-over {
    border-color: var(--gemini-blue);
    background: rgba(66, 165, 245, 0.1);
}

.upload-icon {
    font-size: 48px;
    color: var(--gemini-text-secondary);
    margin-bottom: 16px;
}

.upload-btn {
    background: none;
    border: none;
    color: var(--gemini-blue);
    text-decoration: underline;
    cursor: pointer;
}

.upload-progress {
    margin-top: 20px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: var(--gemini-border);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--gemini-blue);
    transition: width 0.3s ease;
}

.file-list {
    margin-top: 20px;
}

.file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px;
    border: 1px solid var(--gemini-border);
    border-radius: 8px;
    margin-bottom: 8px;
    background: var(--gemini-surface);
}

.file-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.file-name {
    font-weight: 500;
}

.file-size {
    font-size: 12px;
    color: var(--gemini-text-secondary);
}
</style>