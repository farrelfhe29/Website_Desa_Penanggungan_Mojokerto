<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: peternak_list.php');
    exit;
}

$id = (int) $_GET['id'];

/* filesystem path */
$peternakDir = realpath(__DIR__ . '/../uploads/peternak') . '/';
$farmDir     = realpath(__DIR__ . '/../uploads/farm') . '/';

/* ambil data foto dulu */
$stmt = $mysqli->prepare("
    SELECT photo, farm_photo
    FROM peternak
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header('Location: peternak_list.php');
    exit;
}

/* hapus file foto peternak */
if (!empty($data['photo']) && file_exists($peternakDir . $data['photo'])) {
    unlink($peternakDir . $data['photo']);
}

/* hapus file foto peternakan */
if (!empty($data['farm_photo']) && file_exists($farmDir . $data['farm_photo'])) {
    unlink($farmDir . $data['farm_photo']);
}

/* hapus data dari database */
$stmt = $mysqli->prepare("DELETE FROM peternak WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* redirect */
header('Location: peternak_list.php?deleted=1');
exit;
