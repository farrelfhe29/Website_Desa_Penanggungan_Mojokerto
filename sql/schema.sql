-- Ganti nama database sesuai kebutuhan
CREATE DATABASE IF NOT EXISTS penanggungan_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE penanggungan_db;

-- admin
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL, -- simpan hash password
  name VARCHAR(150),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- peternak
CREATE TABLE peternak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  phone VARCHAR(50),
  address TEXT,
  description TEXT,
  image VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- berita
CREATE TABLE berita (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  image VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- pesan (kontak dari pengunjung)
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  email VARCHAR(150),
  phone VARCHAR(50),
  message TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- kontak perangkat desa (opsional statis, bisa diisi langsung di halaman atau di DB)
CREATE TABLE kontak_admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  role VARCHAR(100),
  phone VARCHAR(50),
  email VARCHAR(150)
);

-- contoh admin default (ganti password)
INSERT INTO admins (username, password, name) VALUES ('admin', CONCAT('', ''), 'Administrator');
-- NOTE: Replace the password with a hashed value using PHP password_hash before inserting,
-- or create admin account via a setup php script.
