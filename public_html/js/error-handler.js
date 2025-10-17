// Global error handler for admin panel
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    // Don't show alert for minor errors
    if (e.error && e.error.message && !e.error.message.includes('ResizeObserver')) {
        console.warn('Error caught:', e.error.message);
    }
});

// Handle unhandled promise rejections
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled Promise Rejection:', e.reason);
    e.preventDefault(); // Prevent default browser error handling
});

// AJAX error handler
function handleAjaxError(error, context = '') {
    console.error(`AJAX Error ${context}:`, error);
    
    let message = 'Xatolik yuz berdi';
    
    if (error.response) {
        // Server responded with error status
        if (error.response.status === 404) {
            message = 'Ma\'lumot topilmadi';
        } else if (error.response.status === 403) {
            message = 'Ruxsat berilmagan';
        } else if (error.response.status === 500) {
            message = 'Server xatosi';
        }
    } else if (error.request) {
        // Network error
        message = 'Tarmoq xatosi';
    }
    
    return message;
}

// Form validation helper
function validateForm(formId, requiredFields) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && !field.value.trim()) {
            field.style.borderColor = '#f44336';
            isValid = false;
        } else if (field) {
            field.style.borderColor = 'var(--gemini-border)';
        }
    });
    
    return isValid;
}

// Safe element access
function safeGetElement(id) {
    const element = document.getElementById(id);
    if (!element) {
        console.warn(`Element with id '${id}' not found`);
    }
    return element;
}

// Safe property access
function safeGet(obj, path, defaultValue = null) {
    try {
        return path.split('.').reduce((current, key) => current && current[key], obj) || defaultValue;
    } catch (e) {
        return defaultValue;
    }
}

// Export functions for global use
window.handleAjaxError = handleAjaxError;
window.validateForm = validateForm;
window.safeGetElement = safeGetElement;
window.safeGet = safeGet;