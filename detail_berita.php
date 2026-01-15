<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// Ambil data berita
$stmt = $mysqli->prepare("
    SELECT title, content, image, created_at 
    FROM berita 
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$berita = $stmt->get_result()->fetch_assoc();

if (!$berita) {
    echo "<p>Berita tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<style>
.detail-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
}

.detail-title {
    font-size: 32px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.detail-date {
    color: #888;
    font-size: 14px;
    margin-bottom: 20px;
}

.detail-image {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    border-radius: 14px;
    margin-bottom: 24px;
}

.detail-content {
    font-size: 16px;
    line-height: 1.8;
    color: #333;
    white-space: pre-line;
}

.back-link {
    display: inline-block;
    margin-top: 30px;
    text-decoration: none;
    font-weight: 600;
    color: #4b6584;
}
.back-link:hover {
    text-decoration: underline;
}
</style>

<div class="detail-container">

    <h1 class="detail-title"><?= esc($berita['title']) ?></h1>

    <div class="detail-date">
        Dipublikasikan pada <?= date('d F Y', strtotime($berita['created_at'])) ?>
    </div>

    <?php if ($berita['image'] && file_exists("uploads/" . $berita['image'])): ?>
        <img 
            src="uploads/<?= esc($berita['image']) ?>" 
            alt="<?= esc($berita['title']) ?>" 
            class="detail-image">
    <?php endif; ?>

    <div class="detail-content">
        <?= nl2br(esc($berita['content'])) ?>
    </div>

    <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'list_berita.php' ?>" class="back-link">
    ← Kembali
</a>


</div>

<?php include 'includes/footer.php'; ?>
