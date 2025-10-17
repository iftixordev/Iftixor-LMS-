@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Shop Boshqaruvi</h1>
            <p class="gemini-card-subtitle">Mahsulotlar va sovrinlarni boshqaring</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="gemini-btn btn-animate" onclick="openItemSlidePanel()">
                <i class="fas fa-plus"></i> Yangi mahsulot
            </button>
            <button class="gemini-btn" style="background: #4caf50; color: white;" onclick="openRewardSlidePanel()">
                <i class="fas fa-gift"></i> Yangi namudlar
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $items->count() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami mahsulotlar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $items->where('is_active', true)->count() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Faol mahsulotlar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #ff9800;">{{ $items->sum('stock') ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami zaxira</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($items ?? [] as $item)
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 12px; overflow: hidden; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="height: 200px; background: linear-gradient(135deg, #f5f5f5, #e0e0e0); display: flex; align-items: center; justify-content: center; position: relative;">
                @if($item->image_path ?? false)
                <img src="{{ $item->image_path }}" alt="{{ $item->name }}" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                @else
                <i class="fas fa-gift" style="font-size: 48px; color: var(--gemini-text-secondary);"></i>
                @endif
                <div style="position: absolute; top: 12px; right: 12px; background: {{ ($item->is_active ?? true) ? '#4caf50' : '#f44336' }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                    {{ ($item->is_active ?? true) ? 'Faol' : 'Nofaol' }}
                </div>
            </div>
            <div style="padding: 20px;">
                <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: var(--gemini-text);">{{ $item->name ?? 'N/A' }}</h3>
                <p style="margin: 0 0 16px 0; color: var(--gemini-text-secondary); font-size: 14px; line-height: 1.4;">{{ Str::limit($item->description ?? '', 80) }}</p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div style="background: rgba(33, 150, 243, 0.1); color: var(--gemini-blue); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 14px;">
                        <i class="fas fa-coins"></i> {{ $item->coin_price ?? 0 }} coin
                    </div>
                    <div style="background: {{ ($item->stock ?? 0) > 0 ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)' }}; color: {{ ($item->stock ?? 0) > 0 ? '#4caf50' : '#f44336' }}; padding: 6px 12px; border-radius: 20px; font-size: 12px;">
                        {{ ($item->stock ?? 0) > 0 ? ($item->stock . ' dona') : 'Tugagan' }}
                    </div>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; flex: 1;" onclick="editItem({{ $item->id ?? 0 }})">
                        <i class="fas fa-edit"></i> Tahrirlash
                    </button>
                    <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #4caf50;" onclick="updateStock({{ $item->id ?? 0 }}, {{ $item->stock ?? 0 }})">
                        <i class="fas fa-boxes"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--gemini-text-secondary);">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                <div style="width: 80px; height: 80px; background: var(--gemini-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-store" style="font-size: 32px; color: var(--gemini-text-secondary);"></i>
                </div>
                <div>
                    <div style="font-weight: 500; margin-bottom: 4px; font-size: 18px;">Shop bo'sh</div>
                    <div style="font-size: 14px;">Hali hech qanday mahsulot qo'shilmagan</div>
                </div>
                <button class="gemini-btn" onclick="openItemSlidePanel()">
                    <i class="fas fa-plus"></i> Birinchi mahsulotni qo'shish
                </button>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Item Slide Panel -->
<div id="itemSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeItemSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="itemPanelTitle">Yangi Mahsulot</h2>
                <p class="slide-panel-subtitle">Mahsulot ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeItemSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="itemForm" method="POST" action="{{ route('admin.gamification.store-item') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="itemId" name="item_id">
                <input type="hidden" id="itemFormMethod" name="_method">
                
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-gift"></i>
                        Mahsulot Ma'lumotlari
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Mahsulot nomi *</label>
                        <input type="text" name="name" id="itemName" class="form-input" required placeholder="Masalan: Stiker to'plami">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Narx (coin) *</label>
                            <input type="number" name="coin_price" id="itemPrice" class="form-input" required min="1" placeholder="100">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Zaxira miqdori *</label>
                            <input type="number" name="stock" id="itemStock" class="form-input" required min="0" placeholder="50">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tavsif</label>
                        <textarea name="description" id="itemDescription" class="form-input" rows="3" placeholder="Mahsulot haqida batafsil ma'lumot..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Mahsulot rasmi</label>
                        <div class="file-upload-area">
                            <input type="file" name="image" id="itemImage" class="file-input" accept="image/*">
                            <div class="file-upload-content">
                                <i class="fas fa-image"></i>
                                <p>Rasm yuklash uchun bosing</p>
                                <small>JPG, PNG formatida, maksimal 2MB</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group" id="itemStatusGroup" style="display: none;">
                        <label class="form-label">Holat</label>
                        <select name="is_active" id="itemStatus" class="form-input">
                            <option value="1">Faol</option>
                            <option value="0">Nofaol</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeItemSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="itemForm" class="btn-primary" id="itemSubmitBtn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </div>
</div>

<!-- Reward Slide Panel -->
<div id="rewardSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeRewardSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2>Yangi Namudlar</h2>
                <p class="slide-panel-subtitle">Mukofot va namudlar yarating</p>
            </div>
            <button class="slide-panel-close" onclick="closeRewardSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="rewardForm" method="POST" action="{{ route('admin.gamification.store-reward') }}">
                @csrf
                
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-trophy"></i>
                        Namudlar Ma'lumotlari
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Namudlar turi *</label>
                        <select name="type" id="rewardType" class="form-input" required>
                            <option value="">Turini tanlang</option>
                            <option value="achievement">Yutuq</option>
                            <option value="badge">Nishon</option>
                            <option value="certificate">Sertifikat</option>
                            <option value="discount">Chegirma</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nomi *</label>
                        <input type="text" name="title" id="rewardTitle" class="form-input" required placeholder="Masalan: Eng faol o'quvchi">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Kerakli coinlar</label>
                            <input type="number" name="required_coins" id="rewardCoins" class="form-input" min="0" placeholder="500">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Chegirma (%)</label>
                            <input type="number" name="discount_percent" id="rewardDiscount" class="form-input" min="0" max="100" placeholder="10">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tavsif</label>
                        <textarea name="description" id="rewardDescription" class="form-input" rows="3" placeholder="Namudlar haqida ma'lumot..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeRewardSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="rewardForm" class="btn-primary">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </div>
</div>

<style>
.slide-panel {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.slide-panel.active {
    opacity: 1;
    visibility: visible;
}

.slide-panel-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    backdrop-filter: none;
}

.slide-panel-content {
    width: min(700px, 95vw);
    max-height: 90vh;
    background: var(--gemini-surface);
    display: flex;
    flex-direction: column;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    transform: scale(0.8);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid var(--gemini-border);
}

.slide-panel.active .slide-panel-content {
    transform: scale(1);
}

.slide-panel-header {
    padding: 24px;
    border-bottom: 1px solid var(--gemini-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--gemini-surface);
    border-radius: 16px 16px 0 0;
}

.slide-panel-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: var(--gemini-text);
}

.slide-panel-subtitle {
    margin: 4px 0 0 0;
    color: var(--gemini-text-secondary);
    font-size: 14px;
}

.slide-panel-close {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--gemini-text-secondary);
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.slide-panel-close:hover {
    background: var(--gemini-hover);
    color: var(--gemini-text);
}

.slide-panel-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    max-height: calc(90vh - 140px);
}

.form-section {
    padding: 24px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 20px 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--gemini-text);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-label {
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--gemini-text);
    font-size: 14px;
}

.form-input {
    padding: 12px 16px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
    font-size: 14px;
    transition: all 0.2s ease;
    resize: vertical;
}

.form-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

.file-upload-area {
    position: relative;
    border: 2px dashed var(--gemini-border);
    border-radius: 8px;
    padding: 24px;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #2196f3;
    background: rgba(33, 150, 243, 0.05);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-content i {
    font-size: 32px;
    color: var(--gemini-text-secondary);
    margin-bottom: 12px;
}

.file-upload-content p {
    margin: 0 0 4px 0;
    color: var(--gemini-text);
    font-weight: 500;
}

.file-upload-content small {
    color: var(--gemini-text-secondary);
    font-size: 12px;
}

.slide-panel-footer {
    padding: 24px;
    border-top: 1px solid var(--gemini-border);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: var(--gemini-bg);
    border-radius: 0 0 16px 16px;
}

.btn-secondary {
    padding: 12px 24px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: transparent;
    color: var(--gemini-text);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary:hover {
    background: var(--gemini-hover);
}

.btn-primary {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    background: #2196f3;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    background: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

@media (max-width: 768px) {
    .slide-panel-content {
        width: 100vw;
        height: 100vh;
        border-radius: 0;
        max-height: 100vh;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let isItemEditMode = false;

function openItemSlidePanel() {
    isItemEditMode = false;
    document.getElementById('itemPanelTitle').textContent = 'Yangi Mahsulot';
    document.getElementById('itemForm').action = '{{ route("admin.gamification.store-item") }}';
    document.getElementById('itemFormMethod').value = '';
    document.getElementById('itemStatusGroup').style.display = 'none';
    document.getElementById('itemSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('itemForm').reset();
    
    document.getElementById('itemSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editItem(itemId) {
    isItemEditMode = true;
    document.getElementById('itemPanelTitle').textContent = 'Mahsulotni Tahrirlash';
    document.getElementById('itemForm').action = `/admin/gamification/items/${itemId}`;
    document.getElementById('itemFormMethod').value = 'PUT';
    document.getElementById('itemId').value = itemId;
    document.getElementById('itemStatusGroup').style.display = 'block';
    document.getElementById('itemSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load item data via AJAX
    fetch(`/admin/gamification/items/${itemId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('itemName').value = data.name || '';
            document.getElementById('itemPrice').value = data.coin_price || '';
            document.getElementById('itemStock').value = data.stock || '';
            document.getElementById('itemDescription').value = data.description || '';
            document.getElementById('itemStatus').value = data.is_active ? '1' : '0';
        })
        .catch(error => {
            console.error('Error loading item data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('itemSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeItemSlidePanel() {
    document.getElementById('itemSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    setTimeout(() => {
        document.getElementById('itemForm').reset();
    }, 400);
}

function openRewardSlidePanel() {
    document.getElementById('rewardSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeRewardSlidePanel() {
    document.getElementById('rewardSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    setTimeout(() => {
        document.getElementById('rewardForm').reset();
    }, 400);
}

function updateStock(itemId, currentStock) {
    const newStock = prompt('Yangi zaxira miqdorini kiriting:', currentStock);
    if (newStock !== null && newStock !== '') {
        // AJAX call to update stock
        fetch(`/admin/gamification/items/${itemId}/stock`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ stock: newStock })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Xatolik yuz berdi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Xatolik yuz berdi');
        });
    }
}

// File upload preview
document.getElementById('itemImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = document.querySelector('#itemSlidePanel .file-upload-content');
            content.innerHTML = `
                <img src="${e.target.result}" style="max-width: 120px; max-height: 80px; border-radius: 8px; margin-bottom: 8px; object-fit: cover;">
                <p>${file.name}</p>
                <small>Rasm yuklandi</small>
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.getElementById('itemForm').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'coin_price', 'stock'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('item' + field.charAt(0).toUpperCase() + field.slice(1).replace('_', ''));
        if (input && !input.value.trim()) {
            input.style.borderColor = '#f44336';
            isValid = false;
        } else if (input) {
            input.style.borderColor = 'var(--gemini-border)';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Iltimos, barcha majburiy maydonlarni to\'ldiring!');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeItemSlidePanel();
        closeRewardSlidePanel();
    }
});
</script>
@endsection