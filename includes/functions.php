<?php
// includes/functions.php
require_once __DIR__ . '/../config.php';

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

function upload_image($file, $folder = __DIR__ . '/../uploads/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['image/jpeg','image/png','image/webp'];
    if (!in_array($file['type'], $allowed)) return null;
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $path = $folder . $name;
    if (!move_uploaded_file($file['tmp_name'], $path)) return null;
    return 'uploads/' . $name;
}

function is_admin() {
    return isset($_SESSION['admin_id']);
}
