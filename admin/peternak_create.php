<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin()) header('Location: login.php');

$success = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name        = $_POST['name'] ?? '';
    $phone       = $_POST['phone'] ?? '';
    $address     = $_POST['address'] ?? '';
    $description = $_POST['description'] ?? '';
    $farmDescription = $_POST['farm_description'] ?? '';

    $photoName     = null;
    $farmPhotoName = null;

    /* ===== FOTO PETERNAK ===== */
    if (!empty($_FILES['photo']['name'])) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = "peternak_" . time() . "_" . rand(1000,9999) . "." . $ext;
        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            __DIR__ . '/../uploads/peternak/' . $photoName
        );
    }

    /* ===== FOTO PETERNAKAN ===== */
    if (!empty($_FILES['farm_photo']['name'])) {
        $ext = pathinfo($_FILES['farm_photo']['name'], PATHINFO_EXTENSION);
        $farmPhotoName = "farm_" . time() . "_" . rand(1000,9999) . "." . $ext;
        move_uploaded_file(
            $_FILES['farm_photo']['tmp_name'],
            __DIR__ . '/../uploads/farm/' . $farmPhotoName
        );
    }

    /* ===== INSERT DATABASE ===== */
    $stmt = $mysqli->prepare("
        INSERT INTO peternak
        (name, phone, address, description, photo, farm_photo, farm_description)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssss",
        $name,
        $phone,
        $address,
        $description,
        $photoName,
        $farmPhotoName,
        $farmDescription
    );

    if ($stmt->execute()) {
        $success = "Peternak berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan data.";
    }
}
?>


<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah Peternak - Desa Penanggungan</title>

<style>

  /* ============================
   GLOBAL PAGE STYLE
=============================== */
body {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(180deg, #2c3e50 0%, #4b6584 100%);
    color: #ecf0f1;
}

/* Wrapper Content */
.content {
    padding: 40px 20px;
}

/* ============================
   TITLE + BACK BUTTON
=============================== */
.page-title {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 26px 0;
    text-align: center;
}

.page-title .back-btn {
    position: absolute;
    top: 18px;
    left: 18px; /* pindah ke kiri atas */
    padding: 8px 14px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.18);
    color: #ecf0f1;
    text-decoration: none;
    border-radius: 8px;
    backdrop-filter: blur(4px);
    transition: 0.25s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.page-title .back-btn:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

/* ============================
   FORM CARD
=============================== */
.form-card {
    max-width: 650px;
    margin: 0 auto;
    padding: 28px;
    background: rgba(255,255,255,0.06);
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.14);
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.25);
}

/* ============================
   ALERT BOX
=============================== */
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
}

.alert-success {
    background: rgba(0,255,150,0.12);
    border: 1px solid rgba(0,255,150,0.28);
    color: #b3ffd8;
}

.alert-error {
    background: rgba(255,80,80,0.12);
    border: 1px solid rgba(255,80,80,0.25);
    color: #ffbdbd;
}

/* ============================
   FORM ELEMENTS
=============================== */
.form-group {
    margin-bottom: 18px;
    text-align: left;
    width: 100%;
}

.form-group label {
    width: 80%;
    margin: 0 auto 6px auto;
    font-size: 14px;
    font-weight: 600;
    display: block;
}

.form-group input,
.form-group textarea {
    width: 80%;
    margin: 0 auto;
    display: block;
    padding: 12px 14px;
    font-size: 15px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.16);
    background: rgba(255,255,255,0.1);
    color: #ecf0f1;
    outline: none;
    transition: .2s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    background: rgba(255,255,255,0.18);
    border-color: rgba(255,255,255,0.35);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

/* ============================
   IMAGE PREVIEW
=============================== */
.preview-box {
    margin: 12px auto 0 auto;
    width: 160px;
    height: 160px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ============================
   SUBMIT BUTTON
=============================== */
.btn-submit {
    width: 80%;
    margin: 10px auto 0 auto;
    padding: 14px;
    border: none;
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    cursor: pointer;
    color: #ecf0f1;
    background: linear-gradient(90deg, rgba(255,255,255,0.25), rgba(255,255,255,0.15));
    box-shadow: 0 8px 22px rgba(0,0,0,0.25);
    transition: 0.25s ease;
    display: block;
}

.btn-submit:hover {
    transform: translateY(-3px);
    background: linear-gradient(90deg, rgba(255,255,255,0.35), rgba(255,255,255,0.20));
    box-shadow: 0 10px 28px rgba(0,0,0,0.35);
}

/* ============================
   RESPONSIVE
=============================== */
@media (max-width: 600px) {
    .form-card {
        padding: 20px;
    }
    .page-title {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
}


</style>

</head>
<body>
<!-- CONTENT -->
<div class="content">

    <h2 class="page-title">
        Tambah Peternak
        <a href="peternak_list.php" class="back-btn">Kembali</a>
    </h2>

    <div class="form-card">

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Peternak</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="phone" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" rows="3" required></textarea>
            </div>

            <div class="form-group">
  <label>Deskripsi Peternak</label>
<textarea name="description" rows="3"></textarea>

            </div>

            <div class="form-group">
                <label>Foto Peternak</label>
                <input type="file" name="photo" accept="image/*" onchange="previewImage(event)">
                <div class="preview-box">
                    <img id="imgPreview" src="<?= $base_url ?>/assets/img/no-image.png">
                </div>

                <div class="form-group">
                <label>Deskripsi Peternakan</label>
<textarea name="farm_description" rows="4"
placeholder="Jelaskan kondisi kandang, lokasi, kapasitas ternak, dll"></textarea>
                </div>
                <div class="form-group">
<label>Foto Peternakan</label>
<input type="file" name="farm_photo" accept="image/*">

</div>
            </div>

            <button class="btn-submit" type="submit">Simpan</button>

        </form>

    </div>

</div>

<script>
function previewImage(e) {
    document.getElementById("imgPreview").src = URL.createObjectURL(e.target.files[0]);
}
</script>

</body>
</html>
