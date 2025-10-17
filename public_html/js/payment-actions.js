// Global o'zgaruvchilar
let students = [];
let searchTimeout;

// DOM yuklanganda ishga tushirish
document.addEventListener('DOMContentLoaded', function() {
    console.log('Payment actions initialized');
    initializePaymentModal();
    loadStudents();
});

// Studentlarni yuklash
function loadStudents() {
    // Bu yerda studentlar ro'yxati backend dan keladi
    // Hozircha bo'sh array
    students = window.studentsData || [];
}

// Modal ni ishga tushirish
function initializePaymentModal() {
    const modal = document.getElementById('paymentModal');
    if (!modal) return;
    
    // Modal yopish tugmalari
    const closeButtons = modal.querySelectorAll('.payment-modal-close, .payment-modal-overlay');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', closePaymentModal);
    });
    
    // ESC tugmasi bilan yopish
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closePaymentModal();
        }
    });
    
    // Student qidirish
    const studentSearch = document.getElementById('studentSearch');
    if (studentSearch) {
        studentSearch.addEventListener('input', handleStudentSearch);
    }
    
    // Hisoblash funksiyalari
    const amountInput = document.getElementById('paymentAmount');
    const discountInput = document.getElementById('paymentDiscount');
    
    if (amountInput) amountInput.addEventListener('input', updateCalculation);
    if (discountInput) discountInput.addEventListener('input', updateCalculation);
    
    // Form validatsiya
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', validatePaymentForm);
    }
}

// Modal ochish
function openPaymentModal() {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Focus qo'yish
        setTimeout(() => {
            const searchInput = document.getElementById('studentSearch');
            if (searchInput) searchInput.focus();
        }, 100);
    }
}

// Modal yopish
function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        
        // Formni tozalash
        setTimeout(() => {
            resetPaymentForm();
        }, 300);
    }
}

// Formni tozalash
function resetPaymentForm() {
    const form = document.getElementById('paymentForm');
    if (form) {
        form.reset();
        
        // Method inputni olib tashlash
        const methodInput = form.querySelector('[name="_method"]');
        if (methodInput) methodInput.remove();
        
        // Tanlangan studentni tozalash
        clearSelectedStudent();
        
        // Modal sarlavhasini qaytarish
        const title = document.querySelector('.payment-modal-header h2');
        if (title) title.textContent = 'Yangi To\'lov';
        
        // Hisobni yangilash
        updateCalculation();
    }
}

// Student qidirish
function handleStudentSearch(e) {
    const query = e.target.value.trim();
    
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        hideStudentResults();
        return;
    }
    
    searchTimeout = setTimeout(() => {
        searchStudents(query);
    }, 300);
}

// Studentlarni qidirish
function searchStudents(query) {
    const results = students.filter(student => {
        const fullName = `${student.first_name} ${student.last_name}`.toLowerCase();
        const studentId = student.student_id ? student.student_id.toLowerCase() : '';
        const phone = student.phone ? student.phone.toLowerCase() : '';
        
        return fullName.includes(query.toLowerCase()) || 
               studentId.includes(query.toLowerCase()) ||
               phone.includes(query.toLowerCase());
    });
    
    showStudentResults(results);
}

// Qidiruv natijalarini ko'rsatish
function showStudentResults(results) {
    const container = document.getElementById('studentResults');
    if (!container) return;
    
    if (results.length === 0) {
        container.innerHTML = '<div class="student-result-item">O\'quvchi topilmadi</div>';
    } else {
        container.innerHTML = results.map(student => `
            <div class="student-result-item" onclick="selectStudent(${student.id}, '${student.first_name}', '${student.last_name}', '${student.student_id || ''}', '${student.phone || ''}', '${student.parent_name || ''}')">
                <div style="font-weight: 500;">${student.first_name} ${student.last_name}</div>
                <div style="font-size: 12px; color: #666;">${student.student_id || ''} • ${student.phone || 'Telefon yo\'q'}</div>
            </div>
        `).join('');
    }
    
    container.style.display = 'block';
}

// Qidiruv natijalarini yashirish
function hideStudentResults() {
    const container = document.getElementById('studentResults');
    if (container) {
        container.style.display = 'none';
    }
}

// Studentni tanlash
function selectStudent(id, firstName, lastName, studentId = '', phone = '', parentName = '') {
    // Hidden input ga ID ni qo'yish
    const hiddenInput = document.getElementById('selectedStudentId');
    if (hiddenInput) hiddenInput.value = id;
    
    // Search input ga ismni qo'yish
    const searchInput = document.getElementById('studentSearch');
    if (searchInput) searchInput.value = `${firstName} ${lastName}`;
    
    // Qidiruv natijalarini yashirish
    hideStudentResults();
    
    // Tanlangan studentni ko'rsatish
    showSelectedStudent(firstName, lastName, studentId, phone, parentName);
    
    // Student ma'lumotlarini ko'rsatish
    showStudentInfo(phone, parentName);
}

// Tanlangan studentni ko'rsatish
function showSelectedStudent(firstName, lastName, studentId, phone, parentName) {
    const container = document.getElementById('selectedStudent');
    if (container) {
        container.innerHTML = `
            <div class="selected-student">
                <div class="selected-student-info">
                    <div class="selected-student-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div style="font-weight: 500;">${firstName} ${lastName}</div>
                        <div style="font-size: 12px; color: #666;">${studentId} • ${phone || 'Telefon yo\'q'}</div>
                    </div>
                </div>
                <button type="button" class="clear-student" onclick="clearSelectedStudent()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.style.display = 'block';
    }
}

// Student ma'lumotlarini ko'rsatish
function showStudentInfo(phone, parentName) {
    const phoneElement = document.getElementById('studentPhone');
    const parentElement = document.getElementById('studentParent');
    const infoContainer = document.getElementById('studentInfo');
    
    if (phoneElement) phoneElement.textContent = phone || '-';
    if (parentElement) parentElement.textContent = parentName || '-';
    if (infoContainer) infoContainer.style.display = 'block';
}

// Tanlangan studentni tozalash
function clearSelectedStudent() {
    const hiddenInput = document.getElementById('selectedStudentId');
    const searchInput = document.getElementById('studentSearch');
    const selectedContainer = document.getElementById('selectedStudent');
    const infoContainer = document.getElementById('studentInfo');
    
    if (hiddenInput) hiddenInput.value = '';
    if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
    }
    if (selectedContainer) selectedContainer.style.display = 'none';
    if (infoContainer) infoContainer.style.display = 'none';
}

// Hisobni yangilash
function updateCalculation() {
    const amountInput = document.getElementById('paymentAmount');
    const discountInput = document.getElementById('paymentDiscount');
    
    const amount = parseFloat(amountInput?.value || 0);
    const discount = parseFloat(discountInput?.value || 0);
    
    const discountAmount = (amount * discount) / 100;
    const finalAmount = amount - discountAmount;
    
    // Natijalarni ko'rsatish
    const baseAmountElement = document.getElementById('baseAmount');
    const discountAmountElement = document.getElementById('discountAmount');
    const finalAmountElement = document.getElementById('finalAmount');
    
    if (baseAmountElement) baseAmountElement.textContent = formatNumber(amount) + ' so\'m';
    if (discountAmountElement) discountAmountElement.textContent = formatNumber(discountAmount) + ' so\'m';
    if (finalAmountElement) finalAmountElement.textContent = formatNumber(finalAmount) + ' so\'m';
}

// Raqamni formatlash
function formatNumber(num) {
    return new Intl.NumberFormat('uz-UZ').format(num);
}

// Form validatsiya
function validatePaymentForm(e) {
    const form = e.target;
    const requiredFields = {
        'student_id': 'O\'quvchi tanlanmagan',
        'amount': 'Summa kiritilmagan',
        'payment_method': 'To\'lov usuli tanlanmagan',
        'payment_date': 'Sana kiritilmagan'
    };
    
    let isValid = true;
    let errors = [];
    
    // Majburiy maydonlarni tekshirish
    Object.keys(requiredFields).forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field || !field.value.trim()) {
            isValid = false;
            errors.push(requiredFields[fieldName]);
            if (field) field.style.borderColor = '#f44336';
        } else if (field) {
            field.style.borderColor = '';
        }
    });
    
    // Summa tekshirish
    const amountField = form.querySelector('[name="amount"]');
    if (amountField && parseFloat(amountField.value) <= 0) {
        isValid = false;
        errors.push('Summa 0 dan katta bo\'lishi kerak');
        amountField.style.borderColor = '#f44336';
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Xatoliklar:\n' + errors.join('\n'));
        return false;
    }
    
    return true;
}

// To'lovni tahrirlash
function editPayment(paymentId) {
    // Loading ko'rsatish
    showLoading('To\'lov ma\'lumotlari yuklanmoqda...');
    
    fetch(`/admin/finance/payments/${paymentId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(payment => {
            hideLoading();
            
            // Formni to'ldirish
            fillEditForm(payment);
            
            // Modal ochish
            openPaymentModal();
        })
        .catch(error => {
            hideLoading();
            console.error('Xatolik:', error);
            alert('To\'lovni yuklashda xatolik yuz berdi. Qaytadan urinib ko\'ring.');
        });
}

// Tahrirlash formini to'ldirish
function fillEditForm(payment) {
    const form = document.getElementById('paymentForm');
    if (!form) return;
    
    // Form action ni o'zgartirish
    form.action = `/admin/finance/payments/${payment.id}`;
    
    // PUT method qo'shish
    let methodInput = form.querySelector('[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';
    
    // Maydonlarni to'ldirish
    const fields = {
        'payment_type': payment.payment_type || 'monthly',
        'amount': payment.original_amount || payment.amount,
        'discount_percent': payment.discount_percent || 0,
        'payment_method': payment.payment_method,
        'payment_date': payment.payment_date,
        'status': payment.status,
        'notes': payment.notes || ''
    };
    
    Object.keys(fields).forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && fields[fieldName] !== undefined) {
            field.value = fields[fieldName];
        }
    });
    
    // Studentni tanlash
    if (payment.student) {
        selectStudent(
            payment.student.id,
            payment.student.first_name,
            payment.student.last_name,
            payment.student.student_id || '',
            payment.student.phone || '',
            payment.student.parent_name || ''
        );
    }
    
    // Modal sarlavhasini o'zgartirish
    const title = document.querySelector('.payment-modal-header h2');
    if (title) title.textContent = 'To\'lovni Tahrirlash';
    
    // Hisobni yangilash
    updateCalculation();
}

// To'lovni o'chirish
function deletePayment(paymentId) {
    if (!confirm('Ushbu to\'lovni o\'chirishni xohlaysizmi?\n\nBu amal qaytarib bo\'lmaydi!')) {
        return;
    }
    
    showLoading('To\'lov o\'chirilmoqda...');
    
    fetch(`/admin/finance/payments/${paymentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': getCSRFToken(),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        hideLoading();
        
        if (response.ok) {
            showSuccess('To\'lov muvaffaqiyatli o\'chirildi!');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            throw new Error('Server error');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Xatolik:', error);
        alert('To\'lovni o\'chirishda xatolik yuz berdi. Qaytadan urinib ko\'ring.');
    });
}

// CSRF token olish
function getCSRFToken() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    return metaTag ? metaTag.getAttribute('content') : '';
}

// Loading ko'rsatish
function showLoading(message = 'Yuklanmoqda...') {
    // Loading modal yaratish yoki ko'rsatish
    let loadingModal = document.getElementById('loadingModal');
    if (!loadingModal) {
        loadingModal = document.createElement('div');
        loadingModal.id = 'loadingModal';
        loadingModal.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center;">
                <div style="background: white; padding: 24px; border-radius: 8px; text-align: center; min-width: 200px;">
                    <div class="payment-loading" style="margin: 0 auto 16px;"></div>
                    <div id="loadingMessage">${message}</div>
                </div>
            </div>
        `;
        document.body.appendChild(loadingModal);
    } else {
        document.getElementById('loadingMessage').textContent = message;
        loadingModal.style.display = 'block';
    }
}

// Loading yashirish
function hideLoading() {
    const loadingModal = document.getElementById('loadingModal');
    if (loadingModal) {
        loadingModal.style.display = 'none';
    }
}

// Muvaffaqiyat xabarini ko'rsatish
function showSuccess(message) {
    const successDiv = document.createElement('div');
    successDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4caf50;
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        z-index: 10001;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
    `;
    successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    
    document.body.appendChild(successDiv);
    
    setTimeout(() => {
        successDiv.remove();
    }, 3000);
}

// Click outside to close search results
document.addEventListener('click', function(e) {
    if (!e.target.closest('#studentSearch') && !e.target.closest('#studentResults')) {
        hideStudentResults();
    }
});

// Global funksiyalarni window ga qo'shish
window.openPaymentModal = openPaymentModal;
window.closePaymentModal = closePaymentModal;
window.editPayment = editPayment;
window.deletePayment = deletePayment;
window.selectStudent = selectStudent;
window.clearSelectedStudent = clearSelectedStudent;