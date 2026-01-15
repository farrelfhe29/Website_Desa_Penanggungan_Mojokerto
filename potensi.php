<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';
?>

<style>
    /* =========================
   POTENSI DESA
========================= */
.potensi-hero {
    background:
        linear-gradient(
            rgba(0, 82, 165, 0.55),
            rgba(30, 58, 138, 0.55)
        ),
        url("assets/img/bg-desa.jpeg.webp");

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    color: #fcfbfbff;
    padding: 100px 0;
    text-align: center;
}

.potensi-hero h1 {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 14px;
}

.potensi-hero p {
    font-size: 18px;
    max-width: 760px;
    margin: auto;
    opacity: .95;
}

.potensi-section {
    padding: 80px 0;
}

.potensi-section.alt {
    background: #f8fafc;
}

.potensi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 34px;
    margin-top: 50px;
}

.potensi-card {
    background: #ffffff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 16px 40px rgba(0,0,0,.06);
}

.potensi-card h3 {
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 14px;
    color: #0f172a;
}

.potensi-split {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 50px;
    align-items: center;
}

.potensi-list ul {
    list-style: none;
    padding: 0;
}

.potensi-list li {
    margin-bottom: 12px;
    font-weight: 600;
    color: #334155;
}

.potensi-section.cta {
   background:
        linear-gradient(
            rgba(0, 82, 165, 0.55),
            rgba(30, 58, 138, 0.55)
        ),
        url("assets/img/bg-desa.jpeg.webp");

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    color: #fff;
    padding: 100px 0;
    text-align: center;
}

.potensi-section.cta .container {
    display: flex;
    flex-direction: column;   /* ⬅️ bikin ke bawah */
    align-items: center;
}

.potensi-btn {
    margin-top: 16px;
}

.potensi-section.cta h2 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 14px;
}

.potensi-section.cta p {
    max-width: 700px;
    margin: 0 auto 26px;
}

.potensi-btn {
    display: inline-block;
    background: #ffffff;
    color: #0052a5;
    padding: 14px 28px;
    border-radius: 30px;
    font-weight: 700;
    text-decoration: none;
    transition: .3s ease;
}

.potensi-btn:hover {
    transform: translateY(-3px);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .potensi-split {
        grid-template-columns: 1fr;
    }

    .potensi-hero h1 {
        font-size: 30px;
    }
}

    </style>

<!-- ================= HERO POTENSI ================= -->
<section class="potensi-hero">
    <div class="container">
        <h1>Potensi Desa Penanggungan</h1>
        <p>
            Desa Penanggungan memiliki potensi unggulan di bidang peternakan,
            pertanian, dan lingkungan alam yang mendukung pengembangan ekonomi desa
            serta peluang kunjungan dan investasi.
        </p>
    </div>
</section>

<!-- ================= POTENSI UTAMA ================= -->
<section class="potensi-section">
    <div class="container">

        <div class="section-head">
            <h2>Potensi Unggulan Desa</h2>
            <p>Sumber daya desa yang menjadi kekuatan utama masyarakat</p>
        </div>

        <div class="potensi-grid">
            <div class="potensi-card">
                <h3>🐄 Peternakan Sapi</h3>
                <p>
                    Desa Penanggungan dikenal sebagai salah satu desa penghasil sapi
                    dengan kualitas baik. Sistem pemeliharaan dilakukan secara
                    berkelanjutan oleh peternak berpengalaman.
                </p>
            </div>

            <div class="potensi-card">
                <h3>🐐 Peternakan Kambing</h3>
                <p>
                    Peternakan kambing menjadi salah satu sektor unggulan dengan
                    permintaan pasar yang stabil, baik untuk konsumsi maupun
                    kebutuhan keagamaan.
                </p>
            </div>

            <div class="potensi-card">
                <h3>🐓 Peternakan Ayam</h3>
                <p>
                    Produksi ayam pedaging dan ayam kampung di Desa Penanggungan
                    mendukung kebutuhan pangan masyarakat sekitar.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- ================= PRODUK & PELUANG ================= -->
<section class="potensi-section alt">
    <div class="container potensi-split">

        <div class="potensi-text">
            <h2>Produk & Peluang Ekonomi</h2>
            <p>
                Selain ternak hidup, Desa Penanggungan juga memiliki potensi produk
                turunan seperti daging segar, pupuk kandang, serta pakan ternak
                lokal. Hal ini membuka peluang kerja sama usaha, investasi, dan
                pengembangan UMKM desa.
            </p>
            <p>
                Lingkungan desa yang asri dan sejuk juga mendukung potensi kunjungan
                edukasi peternakan serta wisata berbasis alam dan pertanian.
            </p>
        </div>

        <div class="potensi-list">
            <ul>
                <li>✔ Ternak berkualitas dan sehat</li>
                <li>✔ Peternak berpengalaman</li>
                <li>✔ Produk turunan ternak</li>
                <li>✔ Peluang investasi dan kerja sama</li>
                <li>✔ Potensi wisata edukasi desa</li>
            </ul>
        </div>

    </div>
</section>

<!-- ================= AJAKAN ================= -->
<section class="potensi-section cta">
    <div class="container">
        <h2>Peluang Kunjungan & Kerja Sama</h2>
        <p>
            Desa Penanggungan terbuka untuk kunjungan, kerja sama, dan pengembangan
            potensi desa bersama masyarakat, pelaku usaha, maupun institusi.
        </p>

        <a href="kontak.php" class="potensi-btn">
            Hubungi Perangkat Desa →
        </a>

        <a href="peternak.php" class="potensi-btn">
            Hubungi Peternak →
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
