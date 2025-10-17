<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish - O'quv Markazi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 p-4">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card login-card border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                            <h3 class="fw-bold">Tizimga Kirish</h3>
                            <p class="text-muted">Telefon raqam va parolingizni kiriting</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Telefon raqam
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', '+998') }}" 
                                       placeholder="+998901234567" 
                                       oninput="formatPhone(this)"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Parol
                                </label>
                                <input type="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Parolingizni kiriting" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Meni eslab qol
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-login btn-lg text-white">
                                    <i class="fas fa-sign-in-alt me-2"></i>Kirish
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('register') }}" class="text-decoration-none me-3">
                                Ro'yxatdan o'tish
                            </a>
                            |
                            <a href="{{ route('phone-login') }}" class="text-decoration-none ms-3">
                                <i class="fas fa-mobile-alt me-1"></i>SMS orqali kirish
                            </a>
                        </div>


                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('welcome') }}" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Asosiy sahifaga qaytish
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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