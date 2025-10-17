<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ro'yxatdan o'tish - O'quv Markazi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .register-card { box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-radius: 15px; }
    </style>
</head>
<body class="d-flex align-items-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card register-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3>Ro'yxatdan o'tish</h3>
                            <p class="text-muted mb-4">Yangi hisob yaratish</p>
                            
                            <div class="mb-3">
                                <div class="position-relative d-inline-block">
                                    <img id="photoPreview" src="{{ asset('images/default-avatar.svg') }}" 
                                         class="rounded-circle" width="100" height="100" 
                                         style="object-fit: cover; border: 3px solid #dee2e6;">
                                    <label for="photo" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" 
                                           style="cursor: pointer; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-camera fa-sm"></i>
                                    </label>
                                </div>
                                <input type="file" id="photo" name="photo" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                                <div class="form-text mt-2">Profil rasmi (ixtiyoriy)</div>
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ism *</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Familiya *</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Telefon raqam *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', '+998') }}" placeholder="+998901234567" required onblur="checkPhone()" oninput="formatPhone(this)">
                                </div>
                                <div id="phoneMessage" class="form-text"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tug'ilgan sana *</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                            </div>

                            @if($branches->count() > 1)
                            <div class="mb-3">
                                <label class="form-label">Filial tanlang *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <select name="branch_id" class="form-select" required>
                                        <option value="">Filialni tanlang</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="branch_id" value="{{ $branches->first()->id }}">
                            @endif



                            <div class="mb-3">
                                <label class="form-label">Parol *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                        <i id="passwordIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Ro'yxatdan o'tish
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                Hisobingiz bormi? Kirish
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function checkPhone() {
            const phone = document.getElementById('phone').value;
            const branchId = document.querySelector('select[name="branch_id"]')?.value || document.querySelector('input[name="branch_id"]')?.value;
            const messageDiv = document.getElementById('phoneMessage');
            
            if (phone.length < 9 || !branchId) {
                messageDiv.innerHTML = '';
                return;
            }
            
            fetch('/check-phone', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ phone: phone, branch_id: branchId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    messageDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times"></i> Bu telefon raqam allaqachon ro\'yxatdan o\'tgan</span>';
                    document.getElementById('phone').classList.add('is-invalid');
                } else {
                    messageDiv.innerHTML = '<span class="text-success"><i class="fas fa-check"></i> Telefon raqam mavjud</span>';
                    document.getElementById('phone').classList.remove('is-invalid');
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '';
            });
        }
        
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }
        
        function formatPhone(input) {
            let value = input.value;
            
            // Agar +998 yo'q bo'lsa yoki o'chirilgan bo'lsa, qayta qo'shish
            if (!value.startsWith('+998')) {
                // Faqat raqamlarni olish
                value = value.replace(/\D/g, '');
                
                // Agar 998 bilan boshlansa, + qo'shish
                if (value.startsWith('998')) {
                    value = '+' + value;
                } else {
                    // Boshqa holatlarda +998 qo'shish
                    value = '+998' + value;
                }
            }
            
            // Maksimal uzunlik: +998 + 9 raqam = 13
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            
            input.value = value;
        }
    </script>
</body>
</html>