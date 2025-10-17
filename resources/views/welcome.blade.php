<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O'quv Markazi Tizimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .feature-card {
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">O'quv Markazi Tizimi</h1>
                    <p class="lead mb-4">Zamonaviy ta'lim boshqaruv tizimi. O'qituvchilar, talabalar va administratorlar uchun qulay interfeys.</p>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 me-md-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Kirish
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-info-circle me-2"></i>Batafsil
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-graduation-cap" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold">Tizim Imkoniyatlari</h2>
                    <p class="text-muted">Barcha foydalanuvchilar uchun qulay va zamonaviy interfeys</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="text-primary mb-3">
                                <i class="fas fa-user-graduate fa-3x"></i>
                            </div>
                            <h5 class="card-title">Talabalar Paneli</h5>
                            <p class="card-text">Darslar, topshiriqlar, baholar va to'lovlarni kuzatish</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="text-success mb-3">
                                <i class="fas fa-chalkboard-teacher fa-3x"></i>
                            </div>
                            <h5 class="card-title">O'qituvchilar Paneli</h5>
                            <p class="card-text">Guruhlar, topshiriqlar, baholar va davomat boshqaruvi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="text-warning mb-3">
                                <i class="fas fa-cogs fa-3x"></i>
                            </div>
                            <h5 class="card-title">Admin Paneli</h5>
                            <p class="card-text">To'liq tizim boshqaruvi va hisobotlar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="fw-bold mb-4">Aloqa</h3>
                    <p class="mb-4">Savollaringiz bo'lsa, biz bilan bog'laning</p>
                    <div class="row justify-content-center">
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-phone text-primary mb-2 fa-2x"></i>
                            <p class="mb-0">+998 90 123 45 67</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-envelope text-primary mb-2 fa-2x"></i>
                            <p class="mb-0">info@markaz.uz</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-map-marker-alt text-primary mb-2 fa-2x"></i>
                            <p class="mb-0">Toshkent, O'zbekiston</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>