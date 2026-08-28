<?php
session_start();
if(isset($_POST['login'])){
    if($_POST['user'] == 'admin' && $_POST['pass'] == 'admin'){
        $_SESSION['status'] = 'login';
        header("location:dashboard.php");
    } else { $error = "Username atau Password Salah!"; }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - TOKO ADI MOTOR</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    background: radial-gradient(ellipse at 20% 50%, #1e3a5f 0%, #0f172a 40%, #1a0a2e 100%);
    position: relative; overflow: hidden;
}
body::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(circle at 10% 20%, rgba(249,115,22,.15) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(30,58,95,.4) 0%, transparent 40%);
    pointer-events: none;
}

.login-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 36px 32px;
    width: 340px;
    box-shadow: 0 25px 60px rgba(0,0,0,.4);
    position: relative; z-index: 1;
    animation: slideUp .5s ease;
}
@keyframes slideUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}

.login-logo {
    text-align: center; margin-bottom: 20px;
}
.login-logo .logo-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    border-radius: 14px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 24px; color: #fff;
    box-shadow: 0 8px 20px rgba(249,115,22,.4);
    margin-bottom: 12px;
}
.login-logo .logo-title {
    font-size: 20px; font-weight: 700; letter-spacing: 0.5px; color: #0f172a;
}
.login-logo .logo-title span { color: #f97316; }
.login-logo .logo-sub {
    font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
    color: #94a3b8; margin-top: 2px;
}

.input-group { margin-bottom: 16px; }
.input-label {
    display: block; font-size: 10px; font-weight: 700;
    letter-spacing: 1.2px; text-transform: uppercase;
    color: #374151; margin-bottom: 6px;
}
.input-wrap {
    display: flex; align-items: center;
    border: 1.5px solid #e5e7eb; border-radius: 10px;
    overflow: hidden; background: #f9fafb;
    transition: border-color .2s, box-shadow .2s;
}
.input-wrap:focus-within {
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,.12);
    background: #fff;
}
.input-wrap .input-icon {
    padding: 0 12px; color: #9ca3af; font-size: 14px;
}
.input-wrap input {
    flex: 1; border: none; background: transparent;
    padding: 11px 12px 11px 0;
    font-size: 13px; color: #0f172a; font-family: 'Inter', sans-serif;
    outline: none;
}
.input-wrap input::placeholder { color: #9ca3af; }

.error-msg {
    background: #fee2e2; color: #dc2626;
    border-radius: 8px; padding: 9px 14px;
    font-size: 12px; text-align: center; margin-bottom: 14px;
    display: flex; align-items: center; gap: 6px; justify-content: center;
}

.btn-login {
    width: 100%; padding: 13px;
    background: #0f172a; color: #fff;
    border: none; border-radius: 10px;
    font-size: 13px; font-weight: 700;
    letter-spacing: 1px; text-transform: uppercase;
    cursor: pointer; margin-top: 6px;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: background .2s, transform .15s;
}
.btn-login:hover { background: #1e293b; transform: translateY(-1px); }
.btn-login:active { transform: translateY(0); }

.login-footer {
    text-align: center; margin-top: 22px;
    font-size: 11px; color: #94a3b8;
}
.login-footer span { color: #f97316; }
</style>
</head>
<body>
<div class="login-card">
    <div class="login-logo">
        <div class="logo-icon"><i class="fas fa-cog"></i></div>
        <div class="logo-title">TOKO <span>ADI MOTOR</span></div>
        <div class="logo-sub">Sistem Manajemen Bengkel</div>
    </div>

    <?php if(isset($error)): ?>
    <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="input-group">
            <label class="input-label">Username</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-user"></i></span>
                <input type="text" name="user" placeholder="Masukan username" required>
            </div>
        </div>
        <div class="input-group">
            <label class="input-label">Password</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="pass" placeholder="••••••••" required>
            </div>
        </div>
        <button type="submit" name="login" class="btn-login">
            Masuk Sekarang <i class="fas fa-arrow-right"></i>
        </button>
    </form>

    <div class="login-footer">
        &copy; 2026 <span>Toko Adi Motor</span> Management System
    </div>
</div>
</body>
</html>