<!-- Bulk Actions Component -->
<div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
    <div class="bulk-info">
        <span id="selectedCount">0</span> ta element tanlandi
    </div>
    <div class="bulk-buttons">
        <button class="bulk-btn bulk-btn-primary" onclick="bulkActions.export()">
            <i class="fas fa-download"></i> Eksport
        </button>
        <button class="bulk-btn bulk-btn-warning" onclick="bulkActions.edit()">
            <i class="fas fa-edit"></i> Tahrirlash
        </button>
        <button class="bulk-btn bulk-btn-danger" onclick="bulkActions.delete()">
            <i class="fas fa-trash"></i> O'chirish
        </button>
    </div>
    <button class="bulk-close" onclick="bulkActions.clear()">
        <i class="fas fa-times"></i>
    </button>
</div>

<script>
class BulkActions {
    constructor() {
        this.selectedItems = new Set();
        this.bar = document.getElementById('bulkActionsBar');
        this.counter = document.getElementById('selectedCount');
        this.init();
    }

    init() {
        // Add master checkbox
        const masterCheckbox = document.createElement('input');
        masterCheckbox.type = 'checkbox';
        masterCheckbox.id = 'masterCheckbox';
        masterCheckbox.className = 'bulk-checkbox master-checkbox';
        masterCheckbox.addEventListener('change', this.toggleAll.bind(this));

        // Insert master checkbox in table header
        const firstTh = document.querySelector('table th:first-child');
        if (firstTh) {
            firstTh.innerHTML = `<label class="checkbox-container">
                ${masterCheckbox.outerHTML}
                <span class="checkmark"></span>
            </label>`;
        }

        // Add checkboxes to each row
        this.addRowCheckboxes();
    }

    addRowCheckboxes() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            const firstTd = row.querySelector('td:first-child');
            if (firstTd) {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'bulk-checkbox row-checkbox';
                checkbox.value = row.dataset.id || index;
                checkbox.addEventListener('change', this.toggleItem.bind(this));

                firstTd.innerHTML = `<label class="checkbox-container">
                    ${checkbox.outerHTML}
                    <span class="checkmark"></span>
                </label>`;
            }
        });
    }

    toggleAll(e) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
            this.updateSelection(checkbox);
        });
    }

    toggleItem(e) {
        this.updateSelection(e.target);
        this.updateMasterCheckbox();
    }

    updateSelection(checkbox) {
        if (checkbox.checked) {
            this.selectedItems.add(checkbox.value);
        } else {
            this.selectedItems.delete(checkbox.value);
        }
        this.updateUI();
    }

    updateMasterCheckbox() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const masterCheckbox = document.getElementById('masterCheckbox');

        if (checkedBoxes.length === 0) {
            masterCheckbox.indeterminate = false;
            masterCheckbox.checked = false;
        } else if (checkedBoxes.length === checkboxes.length) {
            masterCheckbox.indeterminate = false;
            masterCheckbox.checked = true;
        } else {
            masterCheckbox.indeterminate = true;
        }
    }

    updateUI() {
        this.counter.textContent = this.selectedItems.size;
        this.bar.style.display = this.selectedItems.size > 0 ? 'flex' : 'none';
    }

    clear() {
        this.selectedItems.clear();
        document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('masterCheckbox').indeterminate = false;
        this.updateUI();
    }

    async export() {
        if (this.selectedItems.size === 0) return;
        
        try {
            const response = await fetch('/admin/bulk/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ids: Array.from(this.selectedItems),
                    type: window.location.pathname.split('/').pop()
                })
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `export-${Date.now()}.xlsx`;
                a.click();
                notifications.show('Eksport muvaffaqiyatli!', 'success');
            }
        } catch (error) {
            notifications.show('Eksport xatoligi!', 'error');
        }
    }

    edit() {
        if (this.selectedItems.size === 0) return;
        
        // Show bulk edit modal
        const modal = document.createElement('div');
        modal.className = 'bulk-modal';
        modal.innerHTML = `
            <div class="bulk-modal-content">
                <h3>Ommaviy tahrirlash</h3>
                <form id="bulkEditForm">
                    <div class="form-group">
                        <label>Holat</label>
                        <select name="status" class="form-control">
                            <option value="">Tanlang...</option>
                            <option value="active">Faol</option>
                            <option value="inactive">Nofaol</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" onclick="this.closest('.bulk-modal').remove()" class="btn btn-secondary">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        `;
        document.body.appendChild(modal);
    }

    async delete() {
        if (this.selectedItems.size === 0) return;
        
        if (!confirm(`${this.selectedItems.size} ta elementni o'chirishni xohlaysizmi?`)) return;

        try {
            const response = await fetch('/admin/bulk/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ids: Array.from(this.selectedItems),
                    type: window.location.pathname.split('/').pop()
                })
            });

            if (response.ok) {
                location.reload();
            }
        } catch (error) {
            notifications.show('O\'chirishda xatolik!', 'error');
        }
    }
}

// Initialize bulk actions if table exists
if (document.querySelector('table')) {
    const bulkActions = new BulkActions();
}
</script>

<style>
.bulk-actions-bar {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--gemini-surface);
    border: 1px solid var(--gemini-border);
    border-radius: 12px;
    padding: 16px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    z-index: 1000;
}

.bulk-info {
    font-weight: 500;
    color: var(--gemini-text);
}

.bulk-buttons {
    display: flex;
    gap: 8px;
}

.bulk-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}

.bulk-btn-primary { background: var(--gemini-blue); color: white; }
.bulk-btn-warning { background: #ff9800; color: white; }
.bulk-btn-danger { background: #f44336; color: white; }

.bulk-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.bulk-close {
    background: none;
    border: none;
    color: var(--gemini-text-secondary);
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
}

.checkbox-container {
    position: relative;
    cursor: pointer;
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    position: relative;
    display: inline-block;
    width: 18px;
    height: 18px;
    background: var(--gemini-surface);
    border: 2px solid var(--gemini-border);
    border-radius: 4px;
    transition: all 0.2s;
}

.checkbox-container input:checked ~ .checkmark {
    background: var(--gemini-blue);
    border-color: var(--gemini-blue);
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}

.bulk-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.bulk-modal-content {
    background: var(--gemini-surface);
    border-radius: 12px;
    padding: 24px;
    min-width: 400px;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 20px;
}
</style>