<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
if (!is_admin()) header('Location: login.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image   = null;

    if ($title === '' || $content === '') {
        $error = 'Judul dan isi berita wajib diisi.';
    } else {

        // Upload gambar
        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];

            if (!in_array($ext, $allowed)) {
                $error = 'Format gambar harus JPG, PNG, atau WEBP.';
            } else {
                $image = uniqid('berita_') . '.' . $ext;
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../uploads/' . $image
                );
            }
        }

        if (!$error) {
            $stmt = $mysqli->prepare(
                "INSERT INTO berita (title, content, image) VALUES (?,?,?)"
            );
            $stmt->bind_param("sss", $title, $content, $image);
            $stmt->execute();

            header('Location: berita_list.php');
            exit;
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah Berita - Desa Penanggungan</title>

<style>
:root {
    --sidebar-bg: linear-gradient(180deg, #2c3e50, #4b6584);
    --sidebar-text: #ecf0f1;
    --hover-bg: rgba(255,255,255,0.12);
    --content-bg: #f5f6fa;
}

body {
    margin:0;
    display:flex;
    background: var(--content-bg);
    font-family:"Segoe UI", Arial, sans-serif;
}

/* SIDEBAR */
.sidebar {
    width:250px;
    background:var(--sidebar-bg);
    color:var(--sidebar-text);
    min-height:100vh;
    padding:20px 16px;
    box-shadow:4px 0 12px rgba(0,0,0,.2);
    position:sticky;
    top:0;
    transition:.3s;
}
.sidebar.collapsed { width:70px; }
.sidebar.collapsed span,
.sidebar.collapsed .admin-info,
.sidebar.collapsed .sidebar-title { display:none; }

.toggle-btn {
    background:rgba(255,255,255,.15);
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:6px;
    cursor:pointer;
    margin-bottom:20px;
}

.logo-box {
    display:flex;
    gap:10px;
    align-items:center;
    margin-bottom:20px;
}
.logo-box img { width:42px;height:42px; }

.sidebar nav a {
    display:flex;
    align-items:center;
    gap:12px;
    color:var(--sidebar-text);
    padding:10px 12px;
    border-radius:8px;
    text-decoration:none;
    margin-bottom:6px;
}
.sidebar nav a:hover { background:var(--hover-bg); }
.sidebar nav a.active { background:rgba(255,255,255,.25); }

/* CONTENT */
.content {
    flex:1;
    padding:32px;
}

.page-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.form-box {
    background:white;
    padding:24px;
    border-radius:14px;
    max-width:720px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}

.form-group {
    margin-bottom:16px;
}
.form-group label {
    display:block;
    font-weight:600;
    margin-bottom:6px;
}
.form-group input,
.form-group textarea {
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-family:inherit;
}
textarea { min-height:160px; resize:vertical; }

.btn-save {
    background:#27ae60;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    border:none;
    font-weight:600;
    cursor:pointer;
}
.btn-back {
    margin-left:10px;
    text-decoration:none;
    color:#555;
}

.alert {
    background:#ffe6e6;
    color:#c0392b;
    padding:12px;
    border-radius:8px;
    margin-bottom:16px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <div class="logo-box">
        <img src="<?= $base_url ?>/assets/img/logo-desa.png">
        <h3 class="sidebar-title">Admin</h3>
    </div>

    <div class="admin-info">
        <p>Halo, <strong><?= esc($_SESSION['admin_name']) ?></strong></p>
    </div>

    <nav>
        <a href="dashboard.php">📊 <span>Dashboard</span></a>
        <a href="peternak_list.php">🐄 <span>Kelola Peternak</span></a>
        <a href="berita_list.php" class="active">📰 <span>Kelola Berita</span></a>
        <a href="messages.php">💬 <span>Pesan Pengunjung</span></a>
        <a href="logout.php" style="color:#ff7675;">🚪 <span>Logout</span></a>
    </nav>
</aside>

<!-- CONTENT -->
<div class="content">

    <div class="page-header">
        <h2>➕ Tambah Berita</h2>
    </div>

    <div class="form-box">

        <?php if ($error): ?>
            <div class="alert"><?= esc($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Judul Berita</label>
                <input type="text" name="title" required>
            </div>

            <div class="form-group">
                <label>Isi Berita</label>
                <textarea name="content" required></textarea>
            </div>

            <div class="form-group">
                <label>Gambar (opsional)</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button class="btn-save">Simpan</button>
            <a href="berita_list.php" class="btn-back">Batal</a>
        </form>

    </div>

</div>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('collapsed');
}
</script>

</body>
</html>
