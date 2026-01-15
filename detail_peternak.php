<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: peternak.php");
    exit;
}

$id = (int) $_GET['id'];

/* filesystem path */
$peternakDir = realpath(__DIR__ . '/uploads/peternak') . '/';
$farmDir     = realpath(__DIR__ . '/uploads/farm') . '/';

$stmt = $mysqli->prepare("
    SELECT name, phone, address, description, photo, farm_photo, farm_description
    FROM peternak
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

if (!$p) {
    echo "<p style='text-align:center'>Data peternak tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<style>
.detail-container {
    max-width: 900px;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 14px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,.15);
}

.back-btn {
    display: inline-block;
    margin-bottom: 20px;
    color: #0984e3;
    text-decoration: none;
    font-weight: 600;
}

.detail-header {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.detail-photo {
    width: 280px;
    height: 220px;
    object-fit: cover;
    border-radius: 12px;
}

.detail-info h2 {
    margin-top: 0;
    color: #2c3e50;
}

.detail-info p {
    margin: 8px 0;
    color: #444;
}

.wa-btn {
    display: inline-block;
    margin-top: 16px;
    padding: 12px 22px;
    background: #25D366;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 6px 16px rgba(0,0,0,.25);
}

.wa-btn:hover {
    background: #1ebe5d;
    transform: translateY(-3px);
}

.section {
    margin-top: 30px;
}

.section h3 {
    margin-bottom: 12px;
    color: #2c3e50;
}

.farm-photo {
    width: 100%;
    max-height: 380px;
    object-fit: cover;
    border-radius: 14px;
    margin-bottom: 16px;
}
</style>

<div class="detail-container">

<a class="back-btn" href="peternak.php">← Kembali ke Daftar Peternak</a>

<!-- HEADER -->
<div class="detail-header">

    <?php if (!empty($p['photo']) && file_exists($peternakDir . $p['photo'])): ?>
        <img class="detail-photo" src="<?= $base_url ?>/uploads/peternak/<?= esc($p['photo']) ?>">
    <?php else: ?>
        <img class="detail-photo" src="<?= $base_url ?>/assets/img/no-image.png">
    <?php endif; ?>

    <div class="detail-info">
        <h2><?= esc($p['name']) ?></h2>
        <p><strong>Alamat:</strong> <?= esc($p['address']) ?></p>

        <a 
            href="https://wa.me/62<?= preg_replace('/[^0-9]/', '', ltrim($p['phone'], '0')) ?>" 
            target="_blank" 
            class="wa-btn">
            💬 Hubungi via WhatsApp
        </a>
    </div>
</div>

<!-- DESKRIPSI PETERNAK -->
<div class="section">
    <h3>Profil Peternak</h3>
    <p><?= nl2br(esc($p['description'])) ?></p>
</div>

<!-- PETERNAKAN -->
<div class="section">
    <h3>Informasi Peternakan</h3>

    <?php if (!empty($p['farm_photo']) && file_exists($farmDir . $p['farm_photo'])): ?>
        <img class="farm-photo" src="<?= $base_url ?>/uploads/farm/<?= esc($p['farm_photo']) ?>">
    <?php endif; ?>

    <?php if (!empty($p['farm_description'])): ?>
        <p><?= nl2br(esc($p['farm_description'])) ?></p>
    <?php else: ?>
        <p><em>Deskripsi peternakan belum tersedia.</em></p>
    <?php endif; ?>
</div>

</div>

<?php include 'includes/footer.php'; ?>
