<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
if (!is_admin()) header('Location: login.php');

// Ambil data berita
$beritas = $mysqli->query("
    SELECT id, title, image, created_at 
    FROM berita 
    ORDER BY created_at DESC
");
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kelola Berita - Desa Penanggungan</title>

<style>
/* ================= ROOT COLOR THEME ================= */
:root {
    --sidebar-bg: linear-gradient(180deg, #2c3e50, #4b6584);
    --sidebar-text: #ecf0f1;
    --hover-bg: rgba(255,255,255,0.12);
    --content-bg: #f5f6fa;
    --card-bg: #ffffff;
}

/* ================= GLOBAL ================= */
body {
    margin: 0;
    display: flex;
    background: var(--content-bg);
    font-family: "Segoe UI", Arial, sans-serif;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    background: var(--sidebar-bg);
    color: var(--sidebar-text);
    min-height: 100vh;
    padding: 20px 16px;
    box-shadow: 4px 0 12px rgba(0,0,0,0.2);
    position: sticky;
    top: 0;
}

.sidebar .logo-box {
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom: 28px;
}

.sidebar .logo-box img {
    width:42px;
    height:42px;
}

.sidebar .admin-info {
    margin-bottom: 20px;
}

.sidebar .admin-info p {
    margin:0;
    font-size:14px;
    opacity:0.85;
}

.sidebar nav a {
    display:flex;
    align-items:center;
    gap:12px;
    color: var(--sidebar-text);
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom:6px;
    text-decoration: none;
    transition: 0.3s ease;
}

.sidebar nav a:hover {
    background: var(--hover-bg);
}

.sidebar nav a.active {
    background: rgba(255,255,255,0.22);
    font-weight:600;
}   

/* Sidebar default */
.sidebar {
    width: 250px;
    background: var(--sidebar-bg);
    color: var(--sidebar-text);
    min-height: 100vh;
    padding: 20px 16px;
    box-shadow: 4px 0 12px rgba(0,0,0,0.2);
    position: sticky;
    top: 0;
    transition: width 0.3s ease;
}

/* Tombol toggle */
.toggle-btn {
    background: rgba(255,255,255,0.15);
    color: var(--sidebar-text);
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 20px;
    font-size: 18px;
    transition: 0.3s;
}

.toggle-btn:hover {
    background: rgba(255,255,255,0.25);
}

/* COLLAPSED SIDEBAR */
.sidebar.collapsed {
    width: 70px;
    padding-left: 10px;
    padding-right: 10px;
}

/* Hidden text when collapsed */
.sidebar.collapsed .sidebar-title,
.sidebar.collapsed .admin-info,
.sidebar.collapsed nav a span {
    display: none;
}

/* Center icons when collapsed */
.sidebar.collapsed nav a {
    justify-content: center;
}

.sidebar.collapsed .logo-box {
    justify-content: center;
}

.sidebar.collapsed .logo-box img {
    width: 34px;
    height: 34px;
}

/* Smooth nav links */
.sidebar nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--sidebar-text);
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom:6px;
    text-decoration: none;
    transition: 0.25s;
}

.sidebar nav a:hover {
    background: var(--hover-bg);
}

@media (max-width: 768px) {
    .sidebar {
        width: 70px;
    }
    .sidebar-title,
    .admin-info,
    nav a span {
        display: none;
    }
}

/* ================= CONTENT ================= */
.content {
    flex: 1;
    padding: 34px;
}

/* PAGE HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-header h2 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
}

/* ADD BUTTON */
.btn-add {
    background: #27ae60;
    color: white;
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    transition: .25s ease;
}

.btn-add:hover {
    opacity: .9;
}

/* ========= TABLE CARD CONTAINER ========= */
.table-box {
    background: white;
    padding: 24px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.10);
    border: 1px solid rgba(0,0,0,0.05);
    animation: fadeIn .4s ease;
}

/* SUBTLE ANIMATION */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ========= TABLE STYLE ========= */
.table-box table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

/* HEADER */
.table-box thead th {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    padding: 14px;
    font-size: 14px;
    text-align: left;
    letter-spacing: .3px;
}

/* BODY */
.table-box tbody td {
    padding: 14px;
    border-bottom: 1px solid #e6e9ef;
    font-size: 14px;
    color: #2c3e50;
}

.table-box tbody tr:last-child td {
    border-bottom: none;
}

/* Hover row */
.table-box tbody tr:hover td {
    background: #f7f9fc;
}

/* ========= THUMB IMAGE ========= */
.thumb {
    width: 70px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

/* ========= ACTION BUTTONS ========= */
.btn-view,
.btn-edit,
.btn-delete {
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: .25s ease;
}

/* VIEW */
.btn-view {
    background: #16a085;
    color: white;
    box-shadow: 0 3px 8px rgba(22, 160, 133, 0.25);
}
.btn-view:hover {
    background: #138d75;
    transform: translateY(-2px);
}

/* EDIT */
.btn-edit {
    background: #f1c40f;
    color: #2c3e50;
    box-shadow: 0 3px 8px rgba(241, 196, 15, 0.25);
}
.btn-edit:hover {
    background: #d4ac0d;
    transform: translateY(-2px);
}

/* DELETE */
.btn-delete {
    background: #e74c3c;
    color: white;
    box-shadow: 0 3px 8px rgba(231, 76, 60, 0.25);
}
.btn-delete:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

/* ========= RESPONSIVE ========= */
@media (max-width: 768px) {
    .table-box thead th:nth-child(3),
    .table-box tbody td:nth-child(3),
    .table-box thead th:nth-child(4),
    .table-box tbody td:nth-child(4) {
        display: none;
    }
}


/* OVERLAY */
.modal-logout {
    display: none; 
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
    animation: fadeIn .3s ease;
}

/* CARD */
.modal-content-logout {
    background: white;
    width: 360px;
    padding: 26px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    animation: popIn .3s ease;
}

.logout-icon {
    margin-bottom: 12px;
}

/* TEXT */
.modal-content-logout h3 {
    margin: 0;
    font-size: 22px;
    color: #2c3e50;
}
.modal-content-logout p {
    margin-top: 6px;
    color: #555;
    font-size: 14px;
}

/* BUTTONS */
.modal-actions {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 12px;
}

.btn-logout {
    background: #e74c3c;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: .3s ease;
}
.btn-logout:hover {
    background: #c0392b;
}

.btn-cancel {
    background: #ecf0f1;
    color: #2c3e50;
    padding: 10px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: .3s ease;
}
.btn-cancel:hover {
    background: #d5d9dc;
}

/* ANIMATIONS */
@keyframes fadeIn {
    from { opacity:0; }
    to   { opacity:1; }
}
@keyframes popIn {
    from { transform:scale(.8); opacity:0; }
    to   { transform:scale(1); opacity:1; }
}


</style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <!-- Tombol collapse -->
    <button class="toggle-btn" onclick="toggleSidebar()">
        ☰ 
    </button>

    <div class="logo-box">
        <img src="<?= $base_url ?>/assets/img/logo-desa.png" alt="Logo Desa" class="sidebar-logo">
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
       <a href="#" onclick="openLogoutModal()" style="color:#ff7675;">🚪 <span>Logout</span> </a>
    </nav>

</aside>

<!-- CONTENT -->
<div class="content">

    <div class="page-header">
        <h2>📰 Kelola Berita Desa</h2>
        <a href="berita_create.php" class="btn-add">+ Tambah Berita</a>
    </div>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Judul</th>
                    <th width="120">Gambar</th>
                    <th width="180">Tanggal</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($b=$beritas->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($b['title']) ?></td>
                    <td>
                        <?php if($b['image'] && file_exists("../uploads/".$b['image'])): ?>
                            <img src="../uploads/<?= esc($b['image']) ?>" class="thumb">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                    <td>
    <a href="../detail_berita.php?id=<?= $b['id'] ?>" 
       target="_blank"
       class="btn-view">Detail</a>

    <a href="berita_edit.php?id=<?= $b['id'] ?>" class="btn-edit">Edit</a>

    <a href="berita_delete.php?id=<?= $b['id'] ?>" 
       onclick="return confirm('Hapus berita ini?')" 
       class="btn-delete">Hapus</a>
</td>

                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- CUSTOM LOGOUT MODAL -->
<div id="logoutModal" class="modal-logout">
    <div class="modal-content-logout">

        <div class="logout-icon">
            <svg width="48" height="48" fill="#e74c3c" viewBox="0 0 24 24">
                <path d="M10 3h10v18H10" stroke="#e74c3c" stroke-width="1.5"/>
                <path d="M15 12H3m0 0l4-4m-4 4l4 4" stroke="#e74c3c" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>

        <h3>Konfirmasi Logout</h3>
        <p>Apakah Anda yakin ingin keluar dari dashboard?</p>

        <div class="modal-actions">
            <a href="logout.php" class="btn-logout">Ya, Logout</a>
            <button onclick="closeLogoutModal()" class="btn-cancel">Batal</button>
        </div>

    </div>
</div>

</body>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");
}


function openLogoutModal() {
    document.getElementById("logoutModal").style.display = "flex";
}

function closeLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
}

</script>

</body>
</html>
