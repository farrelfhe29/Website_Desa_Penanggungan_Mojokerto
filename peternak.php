<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

/* filesystem path untuk cek file */
$peternakDir = realpath(__DIR__ . '/uploads/peternak') . '/';

$stmt = $mysqli->prepare("
    SELECT id, name, phone, address, description, photo
    FROM peternak
    ORDER BY created_at DESC
");
$stmt->execute();
$peternaks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<style>
.page-title {
    text-align: center;
    font-size: 30px;
    font-weight: 700;
    margin: 40px 0 10px;
    color: #2c3e50;
}

.peternak-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.peternak-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
}

.peternak-card {
    background: #4b6584;
    color: #fff;
    border-radius: 16px;
    padding: 18px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 25px rgba(0,0,0,.15);
}

.peternak-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 14px;
}

.peternak-name {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 6px;
}

.peternak-address {
    font-size: 14px;
    opacity: .9;
    margin-bottom: 10px;
}

.peternak-desc {
    font-size: 14px;
    line-height: 1.5;
    flex-grow: 1;
}

.peternak-action {
    margin-top: 16px;
    display: flex;
    gap: 10px;
}

.btn-wa {
    flex: 1;
    text-align: center;
    background: #25D366;
    color: white;
    padding: 10px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
}

.btn-detail {
    flex: 1;
    text-align: center;
    background: rgba(255,255,255,.2);
    color: white;
    padding: 10px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
}

.empty {
    text-align: center;
    color: #777;
    padding: 60px 0;
}
</style>

<h1 class="page-title">Daftar Peternak Desa Penanggungan</h1>

<div class="peternak-wrapper">
    <div class="peternak-grid">

    <?php if (empty($peternaks)): ?>
        <div class="empty">Data peternak belum tersedia</div>
    <?php else: ?>
        <?php foreach ($peternaks as $p): ?>
        <div class="peternak-card">

            <?php if (!empty($p['photo']) && file_exists($peternakDir . $p['photo'])): ?>
                <img src="<?= $base_url ?>/uploads/peternak/<?= esc($p['photo']) ?>">
            <?php else: ?>
                <img src="<?= $base_url ?>/assets/img/no-image.png">
            <?php endif; ?>

            <div class="peternak-name"><?= esc($p['name']) ?></div>
            <div class="peternak-address"><?= esc($p['address']) ?></div>

            <div class="peternak-desc">
                <?= nl2br(esc(substr($p['description'], 0, 120))) ?>...
            </div>

            <div class="peternak-action">
                <a class="btn-wa"
                   target="_blank"
                   href="https://wa.me/62<?= preg_replace('/[^0-9]/', '', $p['phone']) ?>">
                   WhatsApp
                </a>
                <a class="btn-detail" href="detail_peternak.php?id=<?= $p['id'] ?>">
                   Detail
                </a>
            </div>

        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
