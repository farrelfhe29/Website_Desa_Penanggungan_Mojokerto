<?php
require 'config.php';
$pw = password_hash('farrel', PASSWORD_DEFAULT);
$mysqli->query("INSERT INTO admins (username,password,name) VALUES ('farrel','".$mysqli->real_escape_string($pw)."','Administrator')");
echo "Admin berhasil dibuat!";
