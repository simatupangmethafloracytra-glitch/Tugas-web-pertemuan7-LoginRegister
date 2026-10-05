<?php
require 'functions.php';
// Halaman diproteksi: belum login -> kembali ke login
if (!sudahLogin()) {
    setPesan('error', 'Silakan login terlebih dahulu.');
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
  <h1>Dashboard</h1>
  <?php tampilPesan(); ?>
  <p>Halo, <strong><?= bersih($_SESSION['nama']) ?></strong>.</p>
  <p>Email: <?= bersih($_SESSION['email']) ?></p>
  <a class="tombol" href="logout.php">Logout</a>
</main>
</body>
</html>
