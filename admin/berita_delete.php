<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: berita_list.php');
    exit;
}

$id = (int) $_GET['id'];

// Ambil data berita (untuk cek & hapus gambar)
$stmt = $mysqli->prepare("SELECT image FROM berita WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$berita = $stmt->get_result()->fetch_assoc();

if ($berita) {

    // Hapus gambar jika ada
    if (!empty($berita['image'])) {
        $file = __DIR__ . '/../uploads/' . $berita['image'];
        if (file_exists($file)) {
            unlink($file);
        }
    }

    // Hapus data berita
    $stmt = $mysqli->prepare("DELETE FROM berita WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Kembali ke list
header('Location: berita_list.php');
exit;
