<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
$peternakDir = realpath(__DIR__ . '/../uploads/peternak') . '/';
$farmDir     = realpath(__DIR__ . '/../uploads/farm') . '/';

if (!is_admin()) header('Location: login.php');

$stmt = $mysqli->prepare("
    SELECT 
        id,
        name,
        phone,
        address,
        photo,
        farm_photo,
        farm_description,
        created_at
    FROM peternak
    ORDER BY created_at DESC
");

$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Kelola Peternak - Desa Penanggungan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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

/* CONTENT */
.content {
    flex:1;
    padding: 32px;
}

.content h2 {
    margin-top:0;
    font-size:28px;
    color:#2c3e50;
}

.card-grid {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap:18px;
}

.card {
    background:white;
    padding:18px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: .3s ease;
}

.card:hover {
    transform: translateY(-4px);
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

/* ========= CONTENT WRAPPER ========= */
.content {
    flex:1;
    padding: 32px;
}

/* ========= PAGE TITLE ========= */
.page-title {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ========= BUTTON TAMBAH ========= */
.add-btn {
    background: linear-gradient(135deg, #27ae60, #1f8b4e);
    padding: 8px 16px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0, 128, 0, 0.22);
    transition: .25s ease;
    font-size: 15px;
    font-weight: 700;
    color: #f1f8ffff;
    margin-bottom: 20px;
    display: flex;

}
.add-btn:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #1f8b4e, #19733f);
    box-shadow: 0 6px 16px rgba(0, 128, 0, 0.32);
}

/* ========= TABLE CARD CONTAINER ========= */
.table-card {
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
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    padding: 14px;
    font-size: 14px;
    text-align: left;
    border-radius: 6px 6px 0 0;
    letter-spacing: .3px;
}

table td {
    padding: 14px;
    border-bottom: 1px solid #e6e9ef;
    font-size: 14px;
    color: #2c3e50;
}

table tr:last-child td {
    border-bottom: none;
}

/* Hover row */
table tr:hover td {
    background: #f7f9fc;
}

/* ========= ACTION BUTTONS ========= */
.action-btn {
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: .25s ease;
}

/* Edit */
.edit-btn {
    background: #f1c40f;
    color: #2c3e50;
    box-shadow: 0 3px 8px rgba(241, 196, 15, 0.25);
}
.edit-btn:hover {
    background: #d4ac0d;
    transform: translateY(-2px);
}

/* Delete */
.delete-btn {
    background: #e74c3c;
    color: white;
    box-shadow: 0 3px 8px rgba(231, 76, 60, 0.25);
}
.delete-btn:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

/* ========= RESPONSIVE TABLE ========= */
@media (max-width: 768px) {
    table th:nth-child(5),
    table td:nth-child(5),
    table th:nth-child(6),
    table td:nth-child(6) {
        display: none;
    }
}


.peternak-photo {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
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
        <a href="dashboard.php" >📊 <span>Dashboard</span></a>
        <a href="peternak_list.php" class="active">🐄 <span>Kelola Peternak</span></a>
        <a href="berita_list.php">📰 <span>Kelola Berita</span></a>
        <a href="messages.php">💬 <span>Pesan Pengunjung</span></a>
       <a href="#" onclick="openLogoutModal()" style="color:#ff7675;">🚪 <span>Logout</span> </a>
    </nav>

</aside>

<!-- CONTENT -->
<div class="content">

    <h2 class="page-title">
        Daftar Peternak 
    </h2>

<a href="peternak_create.php" class="add-btn">+ Tambah Peternak</a>

    <div class="table-card">
        <table>
            <tr>
                <th>Foto Peternak</th>
<th>Nama</th>
<th>Telepon</th>
<th>Alamat</th>
<th>Foto Peternakan</th>
<th>Deskripsi Peternakan</th>
<th width="180">Aksi</th>
            </tr>

            <?php foreach ($rows as $r): ?>
            <tr>
<td>
<?php if (!empty($r['photo']) && file_exists($peternakDir . $r['photo'])): ?>
    <img src="<?= $base_url ?>/uploads/peternak/<?= esc($r['photo']) ?>" class="peternak-photo">
<?php else: ?>
    <span style="color:#999;font-size:13px;">Tidak ada</span>
<?php endif; ?>
</td>


                <td><?= esc($r['name']) ?></td>
                <td><?= esc($r['phone']) ?></td>
                <td><?= esc($r['address']) ?></td>

<td>
<?php if (!empty($r['farm_photo']) && file_exists($farmDir . $r['farm_photo'])): ?>
    <img src="<?= $base_url ?>/uploads/farm/<?= esc($r['farm_photo']) ?>" class="peternak-photo">
<?php else: ?>
    <span style="color:#999;font-size:13px;">Tidak ada</span>
<?php endif; ?>
</td>


<td>
    <?php if (!empty($r['farm_description'])): ?>
        <?= esc(substr($r['farm_description'], 0, 80)) ?>...
    <?php else: ?>
        <em style="color:#999;font-size:13px;">Kosong</em>
    <?php endif; ?>
</td>
                <td>
                    <a href="peternak_edit.php?id=<?= $r['id'] ?>" class="action-btn edit-btn">Edit</a>
                    <a href="peternak_delete.php?id=<?= $r['id'] ?>"
   class="action-btn delete-btn"
   onclick="return confirm('Yakin ingin menghapus data peternak ini?')">
   Hapus
</a>

                </td>
            </tr>
            <?php endforeach; ?>

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
