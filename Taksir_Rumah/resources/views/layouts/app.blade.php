<!DOCTYPE html>
<html lang="id">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4JHRX3RKMJ"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4JHRX3RKMJ');
    </script>

    <link rel="icon" href="{{ asset('images/fav-icon.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .navbar {
            background: #cfe2ff;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .footer {
            background: #cfe2ff;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }

        .hero-section {
            position: relative;
            text-align: center;
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Holtwood One SC', serif;
            font-weight: bold;
            font-size: 4vw;
            display: inline-block;
            background: linear-gradient(to bottom, white 80%, black 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
        }

        .hero-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(80%);
            object-fit: cover;
        }

        #grafikImages {
            padding: 0 20px;
        }

        @media (max-width: 768px) {
            .hero-text {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .hero-text {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/logo.png') }}" alt="TaksirRumah Logo" width="70">
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container py-4">
            <div class="row align-items-center">

                <div class="col-6 col-md-4 d-flex justify-content-start align-items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="TaksirRumah Logo" width="100">
                </div>

                <div class="col-6 col-md-4 offset-md-4 d-flex flex-column align-items-end text-end">
                    <p class="fw-bold mb-2">Contact Us</p>
                    <div>
                        <a href="#"><img src="{{ asset('images/email.png') }}" alt="Email" width="24" class="mx-1"></a>
                        <a href="#"><img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp" width="24" class="mx-1"></a>
                        <a href="#"><img src="{{ asset('images/social.png') }}" alt="Instagram" width="24" class="mx-1"></a>
                    </div>
                </div>

                <div class="col-12 mt-3 d-flex justify-content-center">
                    <p class="mb-0 text-center">Copyright © 2025 TaksirRumah</p>
                </div>

            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
