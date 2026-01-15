<?php
require 'config.php';
require 'includes/functions.php';
include 'includes/header.php';

// tangani submit form
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    $stmt = $mysqli->prepare("INSERT INTO messages (name,email,phone,message) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$phone,$message);
    if ($stmt->execute()) {
        $success = 'Pesan terkirim. Terima kasih!';
    } else {
        $success = 'Terjadi kesalahan.';
    }
}
?>

<style>
/* =========================
   PAGE WRAPPER
========================= */
.contact-container {
    max-width: 720px;
    margin: 40px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    font-family: "Segoe UI", Arial, sans-serif;
}

/* =========================
   TITLE
========================= */
.contact-container h2 {
    font-size: 28px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    text-align: center;
}

.contact-container h3 {
    margin-top: 30px;
    font-size: 20px;
    color: #4b6584;
}

/* =========================
   ADMIN INFO
========================= */
.contact-container ul {
    list-style: none;
    padding: 0;
    margin: 10px 0 20px;
}

.contact-container ul li {
    padding: 10px 14px;
    margin-bottom: 8px;
    background: #f5f7fb;
    border-radius: 10px;
    color: #34495e;
    font-size: 14px;
}

/* =========================
   FORM
========================= */
.contact-form {
    margin-top: 20px;
}

.contact-form label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #2c3e50;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #dfe4ea;
    font-size: 14px;
    outline: none;
    margin-bottom: 16px;
    transition: .25s ease;
}

.contact-form textarea {
    resize: vertical;
    min-height: 120px;
}

.contact-form input:focus,
.contact-form textarea:focus {
    border-color: #4b6584;
    box-shadow: 0 0 0 3px rgba(75,101,132,0.15);
}

/* =========================
   BUTTON
========================= */
.contact-form button {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    border: none;
    padding: 14px 26px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: .25s ease;
}

.contact-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}

/* =========================
   SUCCESS MESSAGE
========================= */
.note {
    background: #eafaf1;
    border-left: 5px solid #2ecc71;
    padding: 12px 16px;
    border-radius: 8px;
    color: #2c3e50;
    margin-bottom: 16px;
    font-size: 14px;
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width: 600px) {
    .contact-container {
        padding: 20px;
        margin: 20px;
    }
}
</style>

<div class="contact-container">

<h2>Kontak</h2>
<p>Admin Perangkat Desa:</p>
<ul>
  <li>Kepala Desa: Nama - 0812xxxx</li>
  <li>Sekretaris: Nama - 0812xxxx</li>
</ul>

<h3>Kirim Pesan ke Admin</h3>

<?php if($success): ?>
  <p class="note"><?= esc($success) ?></p>
<?php endif; ?>

<form method="post" class="contact-form">
  <label>Nama</label>
  <input name="name" required>

  <label>Email</label>
  <input name="email" type="email" required>

  <label>Telepon</label>
  <input name="phone">

  <label>Pesan</label>
  <textarea name="message" required></textarea>

  <button type="submit">Kirim Pesan</button>
</form>

</div>


<?php include 'includes/footer.php'; ?>
