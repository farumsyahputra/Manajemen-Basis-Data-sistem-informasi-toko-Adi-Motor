<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suku Cadang Kendaraan - TOKO ADI MOTOR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Minimalist soft background */
            color: #0f172a; /* Dark text */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Minimalist Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 60px;
            background: transparent;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 36px; height: 36px;
            background: #f97316;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #fff;
        }

        .logo-title {
            font-size: 15px; font-weight: 700; letter-spacing: 0.5px; color: #0f172a;
        }
        .logo-title span { color: #f97316; }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: #0f172a;
        }

        /* Minimalist Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 40px;
            flex: 1;
        }

        .hero-content {
            text-align: center;
            max-width: 600px;
            padding: 60px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        .badge {
            display: inline-block;
            background: #fff7ed;
            color: #f97316;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }
        
        .hero-title span {
            color: #f97316;
        }

        .hero-description {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 36px;
            line-height: 1.6;
            font-weight: 400;
        }

        .btn-login {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            background: #0f172a; 
            color: white;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        /* Footer for minimal look */
        .footer {
            text-align: center;
            padding: 24px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            nav { padding: 20px; justify-content: center; }
            .nav-links { display: none; }
            .hero { padding: 20px; }
            .hero-content { padding: 40px 20px; }
            .hero-title { font-size: 32px; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo-container">
            <div class="logo-icon"><i class="fas fa-cog"></i></div>
            <div class="logo-title">TOKO <span>ADI MOTOR</span></div>
        </div>
        <div class="nav-links">
            <a href="#">Beranda</a>
            <a href="#">Produk</a>
            <a href="#">Kontak</a>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <div class="badge">Suku Cadang Berkualitas</div>
            <h1 class="hero-title">Solusi Kebutuhan <span>Otomotif</span> Anda</h1>
            <p class="hero-description">Menyediakan berbagai macam suku cadang (sparepart) kendaraan terlengkap dengan mutu terjamin untuk menunjang performa kendaraan kesayangan Anda.</p>
            <a href="login.php" class="btn-login">
                Masuk Sistem <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="footer">
        &copy; 2026 Toko Adi Motor. Seluruh hak cipta dilindungi.
    </div>

</body>
</html>