<!-- Advanced Filters Component -->
<div class="filters-container">
    <div class="filters-header">
        <button class="filters-toggle" onclick="toggleFilters()">
            <i class="fas fa-filter"></i>
            Filtrlar
            <span class="filter-count" id="filterCount" style="display: none;"></span>
        </button>
        <div class="filters-actions">
            <button class="btn-secondary" onclick="clearFilters()">Tozalash</button>
            <button class="btn-primary" onclick="saveFilters()">Saqlash</button>
        </div>
    </div>
    
    <div class="filters-panel" id="filtersPanel" style="display: none;">
        <div class="filters-grid">
            <!-- Date Range Filter -->
            <div class="filter-group">
                <label>Sana oralig'i</label>
                <div class="date-range">
                    <input type="date" id="dateFrom" class="filter-input">
                    <span>dan</span>
                    <input type="date" id="dateTo" class="filter-input">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="filter-group">
                <label>Holat</label>
                <select id="statusFilter" class="filter-input" multiple>
                    <option value="active">Faol</option>
                    <option value="inactive">Nofaol</option>
                    <option value="pending">Kutilmoqda</option>
                </select>
            </div>

            <!-- Search Filter -->
            <div class="filter-group">
                <label>Qidiruv</label>
                <input type="text" id="searchFilter" class="filter-input" placeholder="Nom, telefon, email...">
            </div>

            <!-- Amount Range -->
            <div class="filter-group">
                <label>Summa oralig'i</label>
                <div class="range-inputs">
                    <input type="number" id="amountFrom" class="filter-input" placeholder="Dan">
                    <input type="number" id="amountTo" class="filter-input" placeholder="Gacha">
                </div>
            </div>
        </div>

        <!-- Quick Filters -->
        <div class="quick-filters">
            <button class="quick-filter" onclick="applyQuickFilter('today')">Bugun</button>
            <button class="quick-filter" onclick="applyQuickFilter('week')">Bu hafta</button>
            <button class="quick-filter" onclick="applyQuickFilter('month')">Bu oy</button>
            <button class="quick-filter" onclick="applyQuickFilter('year')">Bu yil</button>
        </div>
    </div>
</div>

<!-- Sort Controls -->
<div class="sort-controls">
    <select id="sortBy" class="sort-select">
        <option value="created_at">Yaratilgan sana</option>
        <option value="name">Nomi</option>
        <option value="amount">Summa</option>
        <option value="status">Holat</option>
    </select>
    <button class="sort-direction" id="sortDirection" onclick="toggleSortDirection()">
        <i class="fas fa-sort-amount-down"></i>
    </button>
</div>

<script>
class AdvancedFilters {
    constructor() {
        this.filters = {};
        this.sortBy = 'created_at';
        this.sortDirection = 'desc';
        this.init();
    }

    init() {
        // Load saved filters
        this.loadFilters();
        
        // Add event listeners
        document.querySelectorAll('.filter-input').forEach(input => {
            input.addEventListener('change', this.updateFilters.bind(this));
            input.addEventListener('input', this.debounce(this.updateFilters.bind(this), 500));
        });

        document.getElementById('sortBy').addEventListener('change', this.updateSort.bind(this));
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    updateFilters() {
        this.filters = {
            dateFrom: document.getElementById('dateFrom').value,
            dateTo: document.getElementById('dateTo').value,
            status: Array.from(document.getElementById('statusFilter').selectedOptions).map(o => o.value),
            search: document.getElementById('searchFilter').value,
            amountFrom: document.getElementById('amountFrom').value,
            amountTo: document.getElementById('amountTo').value
        };

        this.updateFilterCount();
        this.applyFilters();
    }

    updateFilterCount() {
        const activeFilters = Object.values(this.filters).filter(v => 
            v && (Array.isArray(v) ? v.length > 0 : true)
        ).length;

        const countElement = document.getElementById('filterCount');
        if (activeFilters > 0) {
            countElement.textContent = activeFilters;
            countElement.style.display = 'inline-block';
        } else {
            countElement.style.display = 'none';
        }
    }

    updateSort() {
        this.sortBy = document.getElementById('sortBy').value;
        this.applyFilters();
    }

    toggleSortDirection() {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        const icon = document.querySelector('#sortDirection i');
        icon.className = this.sortDirection === 'asc' ? 'fas fa-sort-amount-up' : 'fas fa-sort-amount-down';
        this.applyFilters();
    }

    applyQuickFilter(period) {
        const today = new Date();
        let fromDate, toDate = today.toISOString().split('T')[0];

        switch(period) {
            case 'today':
                fromDate = toDate;
                break;
            case 'week':
                fromDate = new Date(today.setDate(today.getDate() - 7)).toISOString().split('T')[0];
                break;
            case 'month':
                fromDate = new Date(today.setMonth(today.getMonth() - 1)).toISOString().split('T')[0];
                break;
            case 'year':
                fromDate = new Date(today.setFullYear(today.getFullYear() - 1)).toISOString().split('T')[0];
                break;
        }

        document.getElementById('dateFrom').value = fromDate;
        document.getElementById('dateTo').value = toDate;
        this.updateFilters();
    }

    async applyFilters() {
        const params = new URLSearchParams({
            ...this.filters,
            sortBy: this.sortBy,
            sortDirection: this.sortDirection
        });

        // Remove empty values
        for (let [key, value] of params.entries()) {
            if (!value || (Array.isArray(value) && value.length === 0)) {
                params.delete(key);
            }
        }

        // Update URL without reload
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.pushState({}, '', newUrl);

        // Fetch filtered data
        try {
            const response = await fetch(newUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update table content
                const newTable = doc.querySelector('table tbody');
                const currentTable = document.querySelector('table tbody');
                if (newTable && currentTable) {
                    currentTable.innerHTML = newTable.innerHTML;
                }

                // Reinitialize bulk actions
                if (window.bulkActions) {
                    bulkActions.addRowCheckboxes();
                }
            }
        } catch (error) {
            console.error('Filter error:', error);
        }
    }

    saveFilters() {
        localStorage.setItem('savedFilters', JSON.stringify({
            filters: this.filters,
            sortBy: this.sortBy,
            sortDirection: this.sortDirection
        }));
        notifications.show('Filtrlar saqlandi!', 'success');
    }

    loadFilters() {
        const saved = localStorage.getItem('savedFilters');
        if (saved) {
            const data = JSON.parse(saved);
            this.filters = data.filters || {};
            this.sortBy = data.sortBy || 'created_at';
            this.sortDirection = data.sortDirection || 'desc';

            // Apply to UI
            Object.entries(this.filters).forEach(([key, value]) => {
                const element = document.getElementById(key + 'Filter') || document.getElementById(key);
                if (element) {
                    if (element.multiple) {
                        Array.from(element.options).forEach(option => {
                            option.selected = value.includes(option.value);
                        });
                    } else {
                        element.value = value;
                    }
                }
            });
        }
    }

    clearFilters() {
        this.filters = {};
        document.querySelectorAll('.filter-input').forEach(input => {
            if (input.multiple) {
                Array.from(input.options).forEach(option => option.selected = false);
            } else {
                input.value = '';
            }
        });
        this.updateFilterCount();
        this.applyFilters();
    }
}

function toggleFilters() {
    const panel = document.getElementById('filtersPanel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

function clearFilters() {
    if (window.advancedFilters) {
        advancedFilters.clearFilters();
    }
}

function saveFilters() {
    if (window.advancedFilters) {
        advancedFilters.saveFilters();
    }
}

// Initialize
const advancedFilters = new AdvancedFilters();
</script>

<style>
.filters-container {
    background: var(--gemini-surface);
    border: 1px solid var(--gemini-border);
    border-radius: 8px;
    margin-bottom: 20px;
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border-bottom: 1px solid var(--gemini-border);
}

.filters-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    color: var(--gemini-text);
    font-weight: 500;
    cursor: pointer;
}

.filter-count {
    background: var(--gemini-blue);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.filters-actions {
    display: flex;
    gap: 8px;
}

.filters-panel {
    padding: 20px;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.filter-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--gemini-text);
}

.filter-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid var(--gemini-border);
    border-radius: 6px;
    background: var(--gemini-bg);
    color: var(--gemini-text);
}

.date-range, .range-inputs {
    display: flex;
    align-items: center;
    gap: 8px;
}

.quick-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.quick-filter {
    padding: 6px 12px;
    border: 1px solid var(--gemini-border);
    border-radius: 20px;
    background: var(--gemini-bg);
    color: var(--gemini-text);
    cursor: pointer;
    transition: all 0.2s;
}

.quick-filter:hover {
    background: var(--gemini-blue);
    color: white;
    border-color: var(--gemini-blue);
}

.sort-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.sort-select {
    padding: 8px 12px;
    border: 1px solid var(--gemini-border);
    border-radius: 6px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
}

.sort-direction {
    padding: 8px;
    border: 1px solid var(--gemini-border);
    border-radius: 6px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
    cursor: pointer;
}

.btn-primary, .btn-secondary {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary {
    background: var(--gemini-blue);
    color: white;
}

.btn-secondary {
    background: var(--gemini-border);
    color: var(--gemini-text);
}
</style>