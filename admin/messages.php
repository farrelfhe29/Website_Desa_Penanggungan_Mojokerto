<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin()) {
    header('Location: login.php');
    exit;
}

/* Ambil pesan dari tabel messages (hasil submit kontak.php) */
$stmt = $mysqli->prepare("
    SELECT name, email, phone, message, created_at
    FROM messages
    ORDER BY created_at DESC
");
$stmt->execute();
$messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pesan Pengunjung - Admin</title>

<style>
/* ROOT COLOR THEME */
:root {
    --sidebar-bg: linear-gradient(180deg, #2c3e50, #4b6584);
    --sidebar-text: #ecf0f1;
    --hover-bg: rgba(255,255,255,0.12);
    --content-bg: #f5f6fa;
}

/* GLOBAL */
body {
    margin:0;
    display:flex;
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

/* ===== gunakan style dashboard yg sudah ada ===== */
.content {
    flex: 1;
    padding: 32px;
}

.page-title {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
}

/* ===== TABLE ===== */
.table-card {
    background: white;
    padding: 24px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.10);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    padding: 14px;
    text-align: left;
}

td {
    padding: 14px;
    border-bottom: 1px solid #e6e9ef;
    vertical-align: top;
    font-size: 14px;
}

tr:hover td {
    background: #f7f9fc;
}

.empty {
    text-align: center;
    color: #777;
    padding: 40px 0;
}

@media (max-width: 768px) {
    th:nth-child(2),
    td:nth-child(2) {
        display: none; /* hide email on mobile */
    }
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
        <a href="berita_list.php">📰 <span>Kelola Berita</span></a>
        <a href="messages.php" class="active">💬 <span>Pesan Pengunjung</span></a>
       <a href="#" onclick="openLogoutModal()" style="color:#ff7675;">🚪 <span>Logout</span> </a>
    </nav>

</aside>

<!-- CONTENT -->
<div class="content">

<h2 class="page-title">Pesan Pengunjung</h2>

<div class="table-card">
<table>
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>Telepon</th>
    <th>Pesan</th>
    <th>Waktu</th>
</tr>

<?php if (empty($messages)): ?>
<tr>
    <td colspan="5" class="empty">Belum ada pesan masuk</td>
</tr>
<?php else: ?>
<?php foreach ($messages as $m): ?>
<tr>
    <td><?= esc($m['name']) ?></td>
    <td><?= esc($m['email']) ?></td>
    <td><?= esc($m['phone']) ?></td>
    <td><?= nl2br(esc($m['message'])) ?></td>
    <td><?= date('d M Y H:i', strtotime($m['created_at'])) ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
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
</html>
