// Modal oynalar uchun JavaScript
class ModalHandler {
    constructor() {
        this.init();
    }

    init() {
        // ESC tugmasi bilan modal yopish
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });

        // Modal orqa fon bosilganda yopish
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                this.closeModal(e.target);
            }
            // Slide panel overlay bosilganda yopish
            if (e.target.classList.contains('slide-panel-overlay')) {
                const panel = e.target.closest('.slide-panel');
                if (panel) {
                    this.closeSlidePanel(panel);
                }
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('modal-open');
        }
    }

    closeModal(modal) {
        if (typeof modal === 'string') {
            modal = document.getElementById(modal);
        }
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            document.body.classList.remove('modal-open');
        }
    }

    closeAllModals() {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            this.closeModal(modal);
        });
        
        // Slide panel larni ham yopish
        const slidePanels = document.querySelectorAll('.slide-panel.active');
        slidePanels.forEach(panel => {
            this.closeSlidePanel(panel);
        });
    }

    openSlidePanel(panelId) {
        const panel = document.getElementById(panelId);
        if (panel) {
            panel.classList.add('active');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('slide-panel-open');
        }
    }

    closeSlidePanel(panel) {
        if (typeof panel === 'string') {
            panel = document.getElementById(panel);
        }
        if (panel) {
            panel.classList.remove('active');
            document.body.style.overflow = 'auto';
            document.body.classList.remove('slide-panel-open');
        }
    }
}

// Modal handler ni ishga tushirish
const modalHandler = new ModalHandler();

// Global funksiyalar
function openModal(modalId) {
    modalHandler.openModal(modalId);
}

function closeModal(modalId) {
    modalHandler.closeModal(modalId);
}

function openSlidePanel(panelId) {
    modalHandler.openSlidePanel(panelId);
}

function closeSlidePanel(panelId) {
    modalHandler.closeSlidePanel(panelId);
}