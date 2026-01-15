<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

$stmt = $mysqli->prepare("SELECT id,title,content,image,created_at FROM berita ORDER BY created_at DESC LIMIT 6");
$stmt->execute();
$beritas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<style>
  /* =========================
   PROFILE PAGE
========================= */
.profile-hero {
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

.profile-hero h1 {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 14px;
}

.profile-hero p {
    font-size: 18px;
    max-width: 700px;
    margin: auto;
    opacity: .95;
}

.profile-section {
    padding: 80px 0;
}

.profile-section.alt {
    background: #f8fafc;
}

.profile-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 50px;
}

.profile-highlight {
    background: #ffffff;
    padding: 26px;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0,0,0,.06);
}

.profile-highlight ul {
    list-style: none;
    padding: 0;
}

.profile-highlight li {
    margin-bottom: 10px;
    font-weight: 600;
    color: #334155;
}

.visi-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
}

.misi-list li {
    margin-bottom: 10px;
}

.potensi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px,1fr));
    gap: 30px;
    margin-top: 40px;
}

.potensi-item {
    background: #fff;
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 14px 36px rgba(0,0,0,.06);
}

.profile-berita-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px,1fr));
    gap: 30px;
}

.profile-berita-item {
    background: #fff;
    padding: 26px;
    border-radius: 16px;
    box-shadow: 0 14px 36px rgba(0,0,0,.06);
}

.profile-berita-item h4 {
    margin: 10px 0;
}

.profile-berita-item .date {
    font-size: 13px;
    color: #64748b;
}

.profile-berita-item a {
    font-weight: 700;
    color: #0052a5;
    text-decoration: none;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .profile-grid,
    .visi-grid {
        grid-template-columns: 1fr;
    }

    .profile-hero h1 {
        font-size: 30px;
    }
}

  </style>


<!-- ================= HERO PROFILE ================= -->
<section class="profile-hero">
    <div class="container">
        <h1>Profil Desa Penanggungan</h1>
        <p>
            Desa Penanggungan merupakan desa yang terletak di Kecamatan Trawas,
            Kabupaten Mojokerto, dengan potensi utama di bidang peternakan,
            pertanian, dan pariwisata alam.
        </p>
    </div>
    
    
</section>

<!-- ================= TENTANG DESA ================= -->
<section class="profile-section">
    <div class="container profile-grid">

        <div class="profile-text">
            <h2>Tentang Desa</h2>
            <p>
                Desa Penanggungan memiliki sejarah panjang sebagai wilayah agraris
                yang berkembang seiring dengan aktivitas masyarakat dalam bidang
                peternakan dan pertanian. Kondisi geografis yang sejuk dan subur
                menjadikan desa ini sebagai salah satu sentra ternak yang potensial
                di wilayah Trawas.
            </p>
            <p>
                Masyarakat Desa Penanggungan dikenal memiliki semangat gotong royong
                yang tinggi serta keterbukaan terhadap inovasi dan pengembangan
                berbasis teknologi informasi.
            </p>
        </div>

        <div class="profile-highlight">
            <ul>
                <li><strong>Kecamatan:</strong> Trawas</li>
                <li><strong>Kabupaten:</strong> Mojokerto</li>
                <li><strong>Provinsi:</strong> Jawa Timur</li>
                <li><strong>Potensi Utama:</strong> Peternakan & Pertanian</li>
            </ul>
        </div>

    </div>
</section>

<!-- ================= VISI MISI ================= -->
<section class="profile-section alt">
    <div class="container visi-grid">

        <div>
            <h2>Visi</h2>
            <p>
                Terwujudnya Desa Penanggungan yang mandiri, sejahtera, dan berdaya
                saing melalui penguatan potensi lokal dan pelayanan publik yang
                transparan.
            </p>
        </div>

        <div>
            <h2>Misi</h2>
            <ul class="misi-list">
                <li>Meningkatkan kualitas sumber daya manusia.</li>
                <li>Mengembangkan potensi peternakan secara berkelanjutan.</li>
                <li>Mendorong pemanfaatan teknologi informasi desa.</li>
                <li>Memperkuat tata kelola pemerintahan desa.</li>
            </ul>
        </div>

    </div>
</section>

<!-- ================= POTENSI DESA ================= -->
<section class="profile-section">
    <div class="container">
        <h2>Potensi Unggulan Desa</h2>

        <div class="potensi-grid">
            <div class="potensi-item">
                <h3>🐄 Peternakan</h3>
                <p>
                    Desa Penanggungan dikenal sebagai penghasil ternak sapi,
                    kambing, dan ayam dengan kualitas yang baik serta peternak
                    yang berpengalaman.
                </p>
            </div>

            <div class="potensi-item">
                <h3>🌾 Pertanian</h3>
                <p>
                    Lahan pertanian yang subur mendukung produksi hasil tani
                    seperti padi, sayuran, dan tanaman pangan lainnya.
                </p>
            </div>

            <div class="potensi-item">
                <h3>🌄 Lingkungan Alam</h3>
                <p>
                    Lingkungan yang sejuk dan alami menjadi daya tarik wisata
                    serta mendukung kenyamanan aktivitas masyarakat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= BERITA DESA ================= -->
<section class="profile-section alt">
    <div class="container">

        <div class="section-head">
            <h2>Berita Desa</h2>
            <p>Informasi dan kegiatan terbaru di Desa Penanggungan</p>
        </div>

        <div class="profile-berita-list">
            <?php foreach ($beritas as $b): ?>
                <article class="profile-berita-item">
                    <span class="date">
                        <?= date('d M Y', strtotime($b['created_at'])) ?>
                    </span>
                    <h4><?= esc($b['title']) ?></h4>
                    <p><?= esc(substr(strip_tags($b['content']), 0, 200)) ?>...</p>
                    <a href="berita_detail.php?id=<?= $b['id'] ?>">Baca Selengkapnya →</a>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
