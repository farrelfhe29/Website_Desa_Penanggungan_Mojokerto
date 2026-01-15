<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='text-align:center'>Berita tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit;
}

$id = (int) $_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM berita WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$berita = $result->fetch_assoc();

if (!$berita) {
    echo "<p style='text-align:center'>Berita tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<style>
/* =========================
   DETAIL BERITA
========================= */
.section-berita-detail {
    background: #f8fafc;
    padding: 90px 0;
}

.detail-wrapper {
    max-width: 900px;
    margin: auto;
}

.berita-detail {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(15,23,42,.1);
    overflow: hidden;
}

/* IMAGE */
.detail-image img {
    width: 100%;
    height: 420px;
    object-fit: cover;
}

/* CONTENT */
.detail-content {
    padding: 40px 46px 50px;
}

.detail-date {
    display: inline-block;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 10px;
}

.detail-title {
    font-size: 34px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 24px;
    line-height: 1.3;
}

.detail-text {
    font-size: 16px;
    line-height: 1.9;
    color: #334155;
}

.detail-text p {
    margin-bottom: 18px;
}

/* BACK */
.detail-back {
    display: inline-flex;
    align-items: center;
    margin-top: 36px;
    font-weight: 700;
    font-size: 15px;
    color: #0052a5;
    text-decoration: none;
    transition: .3s ease;
}

.detail-back:hover {
    color: #003d80;
    transform: translateX(-4px);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .detail-image img {
        height: 260px;
    }

    .detail-content {
        padding: 26px;
    }

    .detail-title {
        font-size: 26px;
    }
}

</style>


<!-- ================= DETAIL BERITA ================= -->
<section class="section section-berita-detail">
    <div class="container detail-wrapper">

        <article class="berita-detail">

            <!-- IMAGE -->
            <?php if (!empty($berita['image']) && file_exists('uploads/' . $berita['image'])): ?>
                <div class="detail-image">
                    <img src="uploads/<?= esc($berita['image']) ?>" alt="<?= esc($berita['title']) ?>">
                </div>
            <?php endif; ?>

            <!-- CONTENT -->
            <div class="detail-content">
                <span class="detail-date">
                    <?= date('d M Y', strtotime($berita['created_at'])) ?>
                </span>

                <h1 class="detail-title">
                    <?= esc($berita['title']) ?>
                </h1>

                <div class="detail-text">
                    <?= nl2br($berita['content']) ?>
                </div>

                <a href="index.php#berita" class="detail-back">
                    ← Kembali ke Berita
                </a>
            </div>

        </article>

    </div>
</section>
<!-- ================= END DETAIL ================= -->

<?php include 'includes/footer.php'; ?>
