<?php
require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Desa Penanggungan</title>

  <!-- CSS Elegant langsung di header -->
  <style>

    /* ========== GLOBAL ========== */
    * {
      box-sizing: border-box;
      font-family: "Segoe UI", Arial, sans-serif;
    }

    body {
      margin: 0;
      background: #f1f2fbff;
    }

    .container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 16px;
    }

    /* ========== HEADER ELEGANT ========== */
   .site-header {
    position: sticky;
    top: 0;
    z-index: 1000;

    background: linear-gradient(
        135deg,
        #1f2f46 0%,
        #2c3e50 45%,
        #4b6584 100%
    );

    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);

    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
}


.site-header .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 72px;
}


 .site-header h1 a {
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 1.2px;
    color: #ffffff;
    text-decoration: none;
    transition: opacity .3s ease;
}

.site-header h1 a:hover {
    opacity: 0.85;
}


    /* Navbar */
 .nav-menu {
    display: flex;
    align-items: center;
    gap: 26px;
}

.nav-menu a {
    position: relative;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    color: #ecf0f1;
    padding: 6px 2px;
    transition: color .3s ease;
}

/* underline animasi */
.nav-menu a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0;
    height: 2px;
    background: #ffffff;
    transition: width .3s ease;
}

.nav-menu a:hover::after {
    width: 100%;
}

.nav-menu a:hover {
    color: #ffffff;
}

.nav-menu a.active::after {
    width: 100%;
}

.nav-menu a.active {
    color: #ffffff;
}


    /* Responsif */
    @media (max-width: 768px) {
        .site-header .container {
        flex-direction: column;
        height: auto;
        padding: 12px 0;
        gap: 10px;
    }

      .site-header nav a {
        margin: 10px 8px;
        display: inline-block;
      }
    }

    /* MAIN CONTAINER */
    main.container {

      min-height: 70vh;
    }

/* ========== ADMIN ICON ELEGANT ========== */
.admin-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    cursor: pointer;
    transition: .3s ease;
}

.admin-logo:hover {
    background: rgba(255,255,255,0.15);
    transform: translateY(-2px);
}

.admin-logo svg {
    fill: #ecf0f1;
    transition: .3s ease;
}

.admin-logo:hover svg {
    fill: #fff;
    transform: scale(1.1);
}

/* ========== LOGO DESA DI HEADER ========== */
.brand {
    display: flex;
    align-items: center;
}

.logo-desa {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin-right: 10px;
    filter: brightness(95%);
    transition: all .3s ease;
}

/* Hover effect pada brand */
.brand a:hover .logo-desa {
    transform: scale(1.1);
    filter: brightness(110%);
}

/* Brand (logo + teks desa) */
.brand-link {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo-desa {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin-right: 12px;
}

.brand-link span {
    font-size: 26px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 1px;
}

.header-wrapper {
    display: flex;
    align-items: center;   /* semua elemen sejajar vertikal */
    justify-content: space-between;
}

  </style>
</head>

<body>


 <header class="site-header">
  <div class="container header-wrapper">

    <div class="brand">
      <a href="<?= $base_url ?>/index.php" class="brand-link">
        <img src="<?= $base_url ?>/assets/img/logo-desa.png" alt="Logo Desa" class="logo-desa">
        <span>Desa Penanggungan</span>
      </a>
    </div>

    <nav class="nav-menu">
      <a href="<?= $base_url ?>/index.php">Beranda</a>
      <a href="<?= $base_url ?>/profile.php">Profile</a>
      <a href="<?= $base_url ?>/potensi.php">Potensi</a>
      <a href="<?= $base_url ?>/peternak.php">Peternak</a>
      <a href="<?= $base_url ?>/kontak.php">Kontak</a>
    </nav>

    <a href="<?= $base_url ?>/admin/login.php" class="admin-logo">
      <svg width="26" height="26" viewBox="0 0 24 24">
        <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
      </svg>
    </a>

  </div>
</header>



<main class="container">
