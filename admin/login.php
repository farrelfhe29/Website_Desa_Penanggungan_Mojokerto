<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

// bila sudah login redirect
if (is_admin()) header('Location: dashboard.php');

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT id,password,name FROM admins WHERE username = ?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if ($res && password_verify($password, $res['password'])) {
        $_SESSION['admin_id'] = $res['id'];
        $_SESSION['admin_name'] = $res['name'];
        header('Location: dashboard.php'); exit;
    } else {
        $err = "Login gagal. Periksa username & password.";
    }
}
?>
<!doctype html>
<html lang="id">
    
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login - Desa Penanggungan</title>

  <style>

/* Title halaman login admin */
.page-title-admin {
    text-align: center;
    color: var(--accent);
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 18px;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.25);
}

    /* ====== GLOBAL (sesuai tema header/footer) ====== */
    :root{
      --grad-start: #2c3e50;
      --grad-end: #4b6584;
      --accent: #ecf0f1;
      --muted: #dcdde1;
      --card-bg: rgba(255,255,255,0.04);
      --input-bg: rgba(255,255,255,0.06);
      --btn-bg: rgba(255,255,255,0.12);
      --radius: 10px;
      --shadow: 0 8px 30px rgba(12,18,30,0.25);
      --glass-border: 1px solid rgba(255,255,255,0.06);
      font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    html,body{
      height:100%;
      margin:0;
      background: linear-gradient(180deg, var(--grad-start) 0%, var(--grad-end) 100%);
      color: var(--accent);
    }

    /* Center wrapper */
    .auth-wrap{
      min-height:100%;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:28px 16px;
    }

    .auth-card{
      width:100%;
      max-width:460px;
      background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      border: var(--glass-border);
      padding:28px;
      backdrop-filter: blur(6px);
    }

    .auth-brand{
      display:flex;
      align-items:center;
      gap:12px;
      margin-bottom:18px;
    }

    .auth-brand .logo {
      width:46px;
      height:46px;
      border-radius:8px;
      background: rgba(255,255,255,0.05);
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15) inset;
      flex-shrink:0;
    }

    .auth-brand h1{
      font-size:20px;
      margin:0;
      color:var(--accent);
      letter-spacing:0.3px;
    }
    .auth-brand p{
      margin:0;
      color:var(--muted);
      font-size:13px;
    }

    /* Form */
    .form-group{margin-bottom:14px}
    label{display:block;font-size:13px;color:var(--muted);margin-bottom:6px}
    input[type="text"], input[type="password"]{
      width:100%;
      padding:12px 14px;
      border-radius:8px;
      border:1px solid rgba(255,255,255,0.04);
      background: var(--input-bg);
      color:var(--accent);
      outline:none;
      transition: box-shadow .18s ease, transform .12s ease;
      font-size:14px;
    }
    input[type="text"]:focus, input[type="password"]:focus{
      box-shadow: 0 6px 20px rgba(75,101,132,0.18);
      transform: translateY(-1px);
      border-color: rgba(255,255,255,0.12);
    }

    .note-error{
      background: rgba(255,80,80,0.08);
      color: #ffb3b3;
      padding:10px 12px;
      border-radius:8px;
      font-size:13px;
      margin-bottom:12px;
      border: 1px solid rgba(255,80,80,0.08);
    }

    .actions{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      margin-top:8px;
    }

    .btn{
      display:inline-block;
      padding:10px 16px;
      border-radius:8px;
      border: none;
      cursor:pointer;
      font-weight:600;
      background: linear-gradient(90deg, rgba(255,255,255,0.12), rgba(255,255,255,0.08));
      color:var(--accent);
      box-shadow: 0 6px 18px rgba(11,20,34,0.25);
      transition: transform .15s ease, box-shadow .15s ease;
    }
    .btn:hover{ transform: translateY(-3px); box-shadow: 0 10px 28px rgba(11,20,34,0.32); }

    .btn.ghost{
      background: transparent;
      border: 1px solid rgba(255,255,255,0.06);
      color: var(--muted);
      font-weight:600;
    }

    .footer-note{
      margin-top:14px;
      font-size:13px;
      color:var(--muted);
      text-align:center;
    }

    /* small screens */
    @media (max-width:480px){
      .auth-card{ padding:18px; }
      .auth-brand h1{ font-size:18px; }
    }

    /* FORM WRAPPER – membuat form tidak melebar terlalu panjang */
.form-container {
    max-width: 380px;  /* lebar form yang rapi */
    margin: 0 auto;    /* center horizontal */
}

/* Pastikan input tidak melampaui form-container */
.form-container input {
    width: 100%;
}

/* Tombol kembali pojok kiri atas */
.back-btn {
    position: absolute;
    top: 18px;
    left: 18px;
    background: rgba(255,255,255,0.15);
    color: var(--accent);
    padding: 8px 14px;
    font-size: 14px;
    border-radius: 8px;
    text-decoration: none;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,0.12);
    transition: 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.back-btn:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

     .site-footer {
            background: #2c3e50;
            padding: 10px 0;
            margin-top: 40px;
            color: #dcdde1;
            text-align: center;
            border-top: 3px solid rgba(255,255,255,0.1);
            box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
        }

        .site-footer small {
            font-size: 14px;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .site-footer small:hover {
            opacity: 1;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .site-footer small {
                font-size: 13px;
            }
        }

  </style>
</head>
<body>

<a href="<?= $base_url ?>/index.php" class="back-btn">← Kembali</a>

<div class="auth-wrap">

    <div class="auth-card" role="presentation" aria-labelledby="login-title">

      <div class="auth-brand">
        <div class="logo" aria-hidden="true">
          <!-- simple SVG logo; replace with <img src="..."> jika perlu -->
          <img src="<?= $base_url ?>/assets/img/logo-desa.png" alt="Logo Desa" style="width:40px; height:40px;">
            <rect x="3" y="3" width="18" height="18" rx="4" fill="rgba(255,255,255,0.06)"/>
            <path d="M6 12h12" stroke="#ecf0f1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 7v10" stroke="#ecf0f1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
        
        </div>

        <div>
          <h1 id="login-title">Admin Desa Penanggungan</h1>
          <p>Masuk untuk mengelola berita, peternak, & pesan</p>
        </div>
      </div>

      <?php if($err): ?>
        <div class="note-error"><?= esc($err) ?></div>
      <?php endif; ?>

    <form method="post" novalidate>
  <div class="form-container">

    <div class="form-group">
      <label for="username">Username</label>
      <input id="username" name="username" type="text" autocomplete="username" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>

    <div class="actions">
      <button class="btn" type="submit">Masuk</button>
    </div>

  </div>
</form>



      <div class="footer-note">Pastikan kredensial Anda aman. Logout setelah selesai.</div>
    </div>
  </div>

      <footer class="site-footer">
        <div class="container">
            <small>&copy; <?= date('Y') ?> Generasi Abdi Surabaya for Desa Penanggungan Trawas</small>
        </div>
    </footer>
</body>
</html>
