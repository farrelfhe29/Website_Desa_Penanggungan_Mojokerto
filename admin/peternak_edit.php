<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin()) header('Location: login.php');

if (!isset($_GET['id'])) {
    header("Location: peternak_list.php");
    exit;
}

$id = (int) $_GET['id'];

/* filesystem path */
$peternakDir = realpath(__DIR__ . '/../uploads/peternak') . '/';
$farmDir     = realpath(__DIR__ . '/../uploads/farm') . '/';

/* ambil data lama */
$stmt = $mysqli->prepare("
    SELECT name, phone, address, description, photo, farm_photo, farm_description
    FROM peternak
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan");
}

$success = "";
$error   = "";

/* ===== UPDATE DATA ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = $_POST['name'];
    $phone       = $_POST['phone'];
    $address     = $_POST['address'];
    $description = $_POST['description'];
    $farmDescription = $_POST['farm_description'];

    $photoName     = $data['photo'];
    $farmPhotoName = $data['farm_photo'];

    /* ==== FOTO PETERNAK ==== */
    if (!empty($_FILES['photo']['name'])) {
        if ($photoName && file_exists($peternakDir . $photoName)) {
            unlink($peternakDir . $photoName); // hapus lama
        }

        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = "peternak_" . time() . "_" . rand(1000,9999) . "." . $ext;

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            $peternakDir . $photoName
        );
    }

    /* ==== FOTO PETERNAKAN ==== */
    if (!empty($_FILES['farm_photo']['name'])) {
        if ($farmPhotoName && file_exists($farmDir . $farmPhotoName)) {
            unlink($farmDir . $farmPhotoName); // hapus lama
        }

        $ext = pathinfo($_FILES['farm_photo']['name'], PATHINFO_EXTENSION);
        $farmPhotoName = "farm_" . time() . "_" . rand(1000,9999) . "." . $ext;

        move_uploaded_file(
            $_FILES['farm_photo']['tmp_name'],
            $farmDir . $farmPhotoName
        );
    }

    /* ==== UPDATE DATABASE ==== */
    $stmt = $mysqli->prepare("
        UPDATE peternak SET
            name = ?,
            phone = ?,
            address = ?,
            description = ?,
            photo = ?,
            farm_photo = ?,
            farm_description = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssssssi",
        $name,
        $phone,
        $address,
        $description,
        $photoName,
        $farmPhotoName,
        $farmDescription,
        $id
    );

    if ($stmt->execute()) {
        $success = "Data berhasil diperbarui.";
    } else {
        $error = "Gagal memperbarui data.";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Edit Peternak</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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

/* WRAPPER */
.container {
    max-width: 700px;
    margin: 40px auto;
    padding: 28px;
    background: rgba(255,255,255,0.06);
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.14);
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.25);
}

/* BACK BUTTON */
.back {
    display: inline-block;
    margin-bottom: 20px;
    padding: 8px 14px;
  background: rgba(159, 159, 159, 0.15);
    border: 1px solid rgba(255,255,255,0.18);
    color: #2a4d55ff;
    text-decoration: none;
    border-radius: 8px;
    backdrop-filter: blur(4px);
    transition: 0.25s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
.back:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

/* TITLE */
.container h2 {
    text-align: center;
    margin: 0 0 26px 0;
    font-size: 26px;
    font-weight: 700;
}

/* ALERT */
.alert-success {
    background: rgba(0,255,150,0.12);
    border: 1px solid rgba(0,255,150,0.28);
    color: #b3ffd8;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
}
.alert-error {
    background: rgba(255,80,80,0.12);
    border: 1px solid rgba(255,80,80,0.25);
    color: #ffbdbd;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
}

/* FORM */
label {
    display: block;
    margin: 16px auto 6px auto;
    font-size: 14px;
    font-weight: 600;
    width: 80%;
}

input, textarea {
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

input:focus,
textarea:focus {
    background: rgba(255,255,255,0.18);
    border-color: rgba(255,255,255,0.35);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

/* PREVIEW IMAGE */
.preview {
    width: 160px;
    height: 160px;
    margin: 12px auto 0 auto;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* SUBMIT BUTTON */
button {
    width: 80%;
    margin: 24px auto 0 auto;
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
button:hover {
    transform: translateY(-3px);
    background: linear-gradient(90deg, rgba(255,255,255,0.35), rgba(255,255,255,0.20));
    box-shadow: 0 10px 28px rgba(0,0,0,0.35);
}

/* RESPONSIVE */
@media (max-width: 600px) {
    .container {
        padding: 20px;
    }
    label, input, textarea, button {
        width: 100%;
    }
}

</style>
</head>

<body>
<div class="container">

<a href="peternak_list.php" class="back">← Kembali</a>

<h2>Edit Peternak</h2>

<?php if ($success): ?><p style="color:green"><?= $success ?></p><?php endif; ?>
<?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>

<form method="post" enctype="multipart/form-data">

<label>Nama</label>
<input type="text" name="name" value="<?= esc($data['name']) ?>" required>

<label>Telepon</label>
<input type="text" name="phone" value="<?= esc($data['phone']) ?>" required>

<label>Alamat</label>
<textarea name="address"><?= esc($data['address']) ?></textarea>

<label>Deskripsi Peternak</label>
<textarea name="description"><?= esc($data['description']) ?></textarea>

<label>Foto Peternak</label>
<input type="file" name="photo">
<div class="preview">
<?php if ($data['photo']): ?>
    <img src="<?= $base_url ?>/uploads/peternak/<?= esc($data['photo']) ?>">
<?php endif; ?>
</div>

<label>Deskripsi Peternakan</label>
<textarea name="farm_description"><?= esc($data['farm_description']) ?></textarea>

<label>Foto Peternakan</label>
<input type="file" name="farm_photo">
<div class="preview">
<?php if ($data['farm_photo']): ?>
    <img src="<?= $base_url ?>/uploads/farm/<?= esc($data['farm_photo']) ?>">
<?php endif; ?>
</div>

<button type="submit">Update Data</button>
</form>

</div>
</body>
</html>
