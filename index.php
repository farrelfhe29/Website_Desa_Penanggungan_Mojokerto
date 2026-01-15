<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

// ambil 3 berita terbaru
$stmt = $mysqli->prepare("
    SELECT id, title, content, image, created_at 
    FROM berita 
    ORDER BY created_at DESC 
    LIMIT 3
");
$stmt->execute();
$beritas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<style>
/* =====================
   RESET & GLOBAL
===================== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
    color: #222;
    background: #ffffff;
    line-height: 1.8;
}

a {
    text-decoration: none;
    color: #0052a5;
}

h1, h2, h3 {
    font-weight: 700;
    color: #62abf3ff;
}

p {
    font-size: 16px;
    margin-bottom: 16px;
}

/* =====================
   CONTAINER
===================== */
.container {
    max-width: 1180px;
    margin: auto;
    padding: 0 24px;
}

/* =====================
   HERO – COMPANY PROFILE STYLE
===================== */
.hero {
    position: relative;
    width: 100vw;              /* full layar kanan kiri */
    margin-left: calc(-50vw + 50%);
    min-height: 520px;

    background-image: url("assets/img/bg-desa.jpeg.webp");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    display: flex;
    align-items: center;
    color: #fff;
    overflow: hidden;
}

/* Overlay gradasi */
.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0, 43, 92, 0.15) 0%,
        rgba(0, 43, 92, 0.45) 45%,
        rgba(0, 43, 92, 0.85) 100%
    );
    z-index: 1;
}

/* Konten */
.hero .container {
    position: relative;
    z-index: 2;
    padding: 130px 24px 110px;
    max-width: 1180px;

    display: flex;
    flex-direction: column;
    align-items: flex-start;   /* RATA KIRI */
    text-align: left;
}


/* Judul */
.hero h1 {
    font-size: 52px;
    font-weight: 700;
    margin-bottom: 18px;
    letter-spacing: 0.8px;
    line-height: 1.2;

    position: relative;
}

/* Garis aksen ala company profile */
.hero h1::after {
    content: "";
    width: 64px;
    height: 4px;
    background: #ffffff;
    margin-top: 14px;
    display: block;
}

.hero p {
    font-size: 18px;
    max-width: 640px;
    line-height: 1.8;
    opacity: 0.95;
    margin-top: 18px;
}




/* =====================
   SECTION
===================== */
.section {
    position: relative;
    width: 100vw;                         /* full layar */
    margin-left: calc(-50vw + 50%);       /* nempel kiri */
    margin-right: calc(-50vw + 50%);      /* nempel kanan */

    padding: 110px 0;
    background: #ffffff;
    overflow: hidden;
}


.section.alt {
    background: linear-gradient(
        180deg,
        #ffffff 0%,
        #d6e8ffff 100%
    );
}

.section .container {
    position: relative;
    z-index: 1;
    max-width: 1180px;
    margin: auto;
    padding: 0 24px;
}


/* =====================
   PROFILE LAYOUT
===================== */
.profile-grid {
    display: grid;
    grid-template-columns: 1.1fr 1fr;
    gap: 70px;
    align-items: center;
}

/* versi dibalik (kalau dipakai) */
.profile-grid.reverse {
    grid-template-columns: 1fr 1.1fr;
}

.profile-grid h2 {
    font-size: 34px;
    font-weight: 700;
    color: #002b5c;
    margin-bottom: 22px;
    position: relative;
    line-height: 1.3;
}

/* garis aksen */
.profile-grid h2::after {
    content: "";
    width: 60px;
    height: 4px;
    background: #002b5c;
    display: block;
    margin-top: 14px;
}

.profile-grid p {
    font-size: 16.5px;
    line-height: 1.85;
    color: #4a4a4a;
    margin-bottom: 16px;
}


/* =====================
   IMAGE STYLE
===================== */
.profile-grid img {
    width: 100%;
    height: 380px;
    object-fit: cover;

    border-radius: 18px;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);

    transition: transform 0.5s ease, box-shadow 0.5s ease;
}

/* hover halus */
.profile-grid img:hover {
    transform: scale(1.03);
    box-shadow: 0 26px 55px rgba(0, 0, 0, 0.18);
}


/* =====================
   LIST
===================== */
ul {
    padding-left: 18px;
}

ul li {
    margin-bottom: 8px;
}

/* =========================
   BERITA TERBARU
========================= */
.section-berita {
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    padding: 88px 0;
}

/* =========================
   HEAD
========================= */
.section-head {
    text-align: center;
    margin-bottom: 56px;
}

.section-head h2 {
    font-size: 34px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 14px;
    letter-spacing: .3px;
}

.section-head p {
    font-size: 16px;
    color: #64748b;
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.65;
}

/* =========================
   GRID
========================= */
.berita-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 40px;
}

/* =========================
   CARD
========================= */
.berita-item {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
    transition: transform .45s ease, box-shadow .45s ease;
}

.berita-item::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        120deg,
        rgba(0,82,165,.06),
        rgba(0,82,165,0)
    );
    opacity: 0;
    transition: opacity .45s ease;
}

.berita-item:hover::before {
    opacity: 1;
}

.berita-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 26px 64px rgba(15, 23, 42, 0.15);
}

/* =========================
   IMAGE
========================= */
.berita-thumb {
    position: relative;
    overflow: hidden;
}

.berita-thumb img {
    width: 100%;
    height: 230px;
    object-fit: cover;
    transition: transform .6s ease;
}

.berita-item:hover .berita-thumb img {
    transform: scale(1.06);
}

/* =========================
   CONTENT
========================= */
.berita-body {
    padding: 32px 42px 38px 36px;
    position: relative;
    z-index: 1;
}

/* DATE */
.berita-date {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    display: inline-block;
    margin-bottom: 12px;
}

/* TITLE */
.berita-title {
    font-size: 19px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 14px;
    line-height: 1.45;
    max-width: 92%;
}

/* TEXT */
.berita-text {
    font-size: 15px;
    color: #475569;
    line-height: 1.75;
    max-width: 92%;
}

/* =========================
   LINK
========================= */
.berita-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
    font-size: 15px;
    font-weight: 700;
    color: #0052a5;
    text-decoration: none;
    transition: all .3s ease;
}

.berita-more::after {
    content: "→";
    font-size: 18px;
    transition: transform .3s ease;
}

.berita-more:hover {
    color: #003d80;
}

.berita-more:hover::after {
    transform: translateX(6px);
}


.hero-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    margin-top: 28px;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    text-decoration: none;
    letter-spacing: 0.3px;

    transition: all 0.3s ease;
}

/* garis bawah elegan */
.hero-link::after {
    content: "";
    width: 0;
    height: 2px;
    background: #ffffff;
    display: block;
    margin-top: 6px;
    transition: width 0.3s ease;
}

.hero-link:hover::after {
    width: 100%;
}

/* animasi panah */
.hero-link span {
    transition: transform 0.3s ease;
}

.hero-link:hover span {
    transform: translateX(6px);
}


/* =====================
   RESPONSIVE
===================== */
@media (max-width: 768px) {
    .profile-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .profile-grid img {
        height: 260px;
    }

    .profile-grid h2 {
        font-size: 28px;
    }

    .hero h1 {
        font-size: 32px;
    }
}

.profile-grid > div,
.profile-grid img {
    animation: fadeUp 0.9s ease forwards;
}

.profile-grid img {
    animation-delay: 0.15s;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

  </style>

<section class="hero">
    <div class="container">
        <h1>Desa Penanggungan</h1>
        <p>
            Desa administratif di Kecamatan Trawas, Kabupaten Mojokerto
            dengan potensi alam, budaya, dan peternakan unggulan.
        </p>

        <a href="profile.php" class="hero-link">
            Lihat Selengkapnya <span>→</span>
        </a>
    </div>
</section>



    <section class="section">
    <div class="container profile-grid">
        <div>
            <h2>Informasi Umum Desa</h2>
            <p>
                Desa Penanggungan merupakan salah satu desa administratif di
                Kecamatan Trawas, Kabupaten Mojokerto, Provinsi Jawa Timur.
                Desa ini berada di lereng Gunung Penanggungan dengan kondisi
                alam yang asri dan udara yang sejuk.
            </p>
            <p>
                Desa Penanggungan dikenal sebagai desa wisata dengan potensi
                agrowisata, pertanian, peternakan, kuliner lokal, serta
                kesenian tradisional seperti tari jaranan dan tradisi
                sedekah bumi.
            </p>
        </div>

        <img src="assets/img/bg-desa.jpeg.webp" alt="Desa Penanggungan">
    </div>
</section>


<section class="section alt">
    <div class="container profile-grid reverse">
        <img src="assets/img/bg-desa.jpeg.webp" alt="Gunung Penanggungan">

        <div>
            <h2>Lokasi Desa</h2>
            <p>
                Desa Penanggungan terletak di Kecamatan Trawas, Kabupaten Mojokerto,
                Provinsi Jawa Timur. Lokasinya berada di kaki Gunung Penanggungan
                dan dekat dengan Gunung Welirang.
            </p>
            <p>
                Kondisi geografis perbukitan menjadikan desa ini memiliki panorama
                alam yang indah serta mendukung pengembangan wisata alam.
            </p>
        </div>
    </div>
</section>


<section class="section">
    <div class="container profile-grid">
        <div>
            <h2>Sejarah dan Asal Usul</h2>
            <p>
                Nama Desa Penanggungan berasal dari tokoh Ki Ageng Aryo
                Penanggungan yang dipercaya sebagai pendiri desa berdasarkan
                cerita rakyat setempat.
            </p>

            <ul>
                <li>Dusun Penanggungan</li>
                <li>Dusun Ngembes</li>
                <li>Dusun Kemendung</li>
                <li>Dusun Sendang</li>
            </ul>
        </div>

        <img src="assets/img/bg-desa.jpeg.webp" alt="Budaya Desa">
    </div>
</section>



<!-- ================= BERITA TERBARU ================= -->
<section class="section section-berita">
    <div class="container">

        <div class="section-head">
            <h2>Berita Terbaru</h2>
            <p>Informasi dan kegiatan terbaru Desa Penanggungan</p>
        </div>

        <div class="berita-grid">
            <?php if (!empty($beritas)): ?>
                <?php foreach ($beritas as $b): ?>
                    <article class="berita-item">

                        <div class="berita-thumb">
                            <?php if (!empty($b['image']) && file_exists('uploads/' . $b['image'])): ?>
                                <img src="uploads/<?= esc($b['image']) ?>" alt="<?= esc($b['title']) ?>">
                            <?php else: ?>
                                <img src="assets/img/default-berita.jpg" alt="Berita Desa">
                            <?php endif; ?>
                        </div>


                        <div class="berita-body">
                            <span class="berita-date">
                                <?= date('d M Y', strtotime($b['created_at'])) ?>
                            </span>

                            <h3 class="berita-title">
                                <?= esc($b['title']) ?>
                            </h3>

                            <p class="berita-text">
                                <?= esc(substr(strip_tags($b['content']), 0, 140)) ?>...
                            </p>

                            <a href="berita_detail.php?id=<?= $b['id'] ?>" class="berita-more">
                                Selengkapnya →
                            </a>
                        </div>

                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;color:#64748b;">
                    Belum ada berita yang ditampilkan.
                </p>
            <?php endif; ?>
        </div>

    </div>
</section>
<!-- ================= END BERITA ================= -->


<?php include 'includes/footer.php'; ?>
