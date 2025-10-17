<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telefon orqali kirish</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .auth-card { background: white; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
        .step { display: none; }
        .step.active { display: block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="auth-card p-4">
                    <div class="text-center mb-4">
                        <h3>Telefon orqali kirish</h3>
                        <p class="text-muted">Telefon raqamingizni kiriting</p>
                    </div>

                    <!-- Step 1: Phone Number -->
                    <div id="step1" class="step active">
                        <form id="phoneForm">
                            <div class="mb-3">
                                <label class="form-label">Telefon raqam</label>
                                <input type="tel" class="form-control" id="phone" placeholder="+998901234567" required>
                                <div class="form-text">Format: +998901234567</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="sendCodeBtn">
                                Kod yuborish
                            </button>
                        </form>
                    </div>

                    <!-- Step 2: Verification Code -->
                    <div id="step2" class="step">
                        <form id="verifyForm">
                            <div class="mb-3">
                                <label class="form-label">Tasdiqlash kodi</label>
                                <input type="text" class="form-control text-center" id="code" placeholder="12345" maxlength="5" required>
                                <div class="form-text">SMS orqali yuborilgan 5 raqamli kodni kiriting</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="verifyBtn">
                                Tasdiqlash
                            </button>
                            <button type="button" class="btn btn-link w-100" onclick="goToStep1()">
                                Orqaga
                            </button>
                        </form>
                    </div>

                    <!-- Step 3: Registration Form -->
                    <div id="step3" class="step">
                        <form id="registrationForm">
                            <div class="mb-3">
                                <label class="form-label">Ism</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Familiya</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tug'ilgan sana</label>
                                <input type="date" class="form-control" id="birthDate">
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="registerBtn">
                                Ro'yxatdan o'tish
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">Email orqali kirish</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPhone = '';
        let requestId = '';

        // CSRF token setup
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Step 1: Send Code
        document.getElementById('phoneForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const phone = document.getElementById('phone').value;
            const btn = document.getElementById('sendCodeBtn');
            
            if (!phone.match(/^\+998[0-9]{9}$/)) {
                alert('Telefon raqam formatini to\'g\'ri kiriting: +998901234567');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Yuborilmoqda...';

            try {
                const response = await fetch('/api/auth/send-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ phone })
                });

                const data = await response.json();

                if (response.ok) {
                    currentPhone = phone;
                    requestId = data.request_id;
                    goToStep2();
                } else {
                    alert(data.error || 'Xatolik yuz berdi');
                }
            } catch (error) {
                alert('Tarmoq xatosi');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Kod yuborish';
            }
        });

        // Step 2: Verify Code
        document.getElementById('verifyForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const code = document.getElementById('code').value;
            const btn = document.getElementById('verifyBtn');

            if (code.length !== 5) {
                alert('5 raqamli kodni kiriting');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Tekshirilmoqda...';

            try {
                const response = await fetch('/api/auth/verify-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        phone: currentPhone,
                        code: code,
                        request_id: requestId
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    if (data.new_user) {
                        goToStep3();
                    } else {
                        window.location.href = '/admin/dashboard';
                    }
                } else {
                    alert(data.error || 'Xatolik yuz berdi');
                }
            } catch (error) {
                alert('Tarmoq xatosi');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Tasdiqlash';
            }
        });

        // Step 3: Complete Registration
        document.getElementById('registrationForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const birthDate = document.getElementById('birthDate').value;
            const btn = document.getElementById('registerBtn');

            btn.disabled = true;
            btn.textContent = 'Ro\'yxatdan o\'tkazilmoqda...';

            try {
                const response = await fetch('/api/auth/complete-registration', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        phone: currentPhone,
                        first_name: firstName,
                        last_name: lastName,
                        birth_date: birthDate
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    window.location.href = '/student/dashboard';
                } else {
                    alert(data.error || 'Xatolik yuz berdi');
                }
            } catch (error) {
                alert('Tarmoq xatosi');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Ro\'yxatdan o\'tish';
            }
        });

        function goToStep1() {
            document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
            document.getElementById('step1').classList.add('active');
        }

        function goToStep2() {
            document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
            document.getElementById('step2').classList.add('active');
            document.getElementById('code').focus();
        }

        function goToStep3() {
            document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
            document.getElementById('step3').classList.add('active');
            document.getElementById('firstName').focus();
        }
    </script>
</body>
</html>