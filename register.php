<?php
require 'functions.php';
if (sudahLogin()) redirect('dashboard.php');

$errors = [];
$nama = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $konfirm  = $_POST['konfirmasi'] ?? '';

    // Validasi nama
    if ($nama === '' || mb_strlen($nama) < 2 || mb_strlen($nama) > 50) {
        $errors[] = 'Nama harus 2-50 karakter.';
    }
    // Validasi email dengan filter_var()
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    } elseif (cariUser($email) !== null) {
        // Cek duplikasi email
        $errors[] = 'Email sudah terdaftar. Gunakan email lain atau login.';
    }
    // Validasi password
    if (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter.';
    }
    if ($password !== $konfirm) {
        $errors[] = 'Konfirmasi password tidak sama.';
    }

    if (!$errors) {
        $users = ambilUsers();
        $users[] = [
            'id'         => uniqid('u_'),
            'nama'       => $nama,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT), // hash
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if (simpanUsers($users)) {
            setPesan('sukses', 'Registrasi berhasil! Silakan login.');
            redirect('login.php');
        }
        $errors[] = 'Gagal menyimpan data. Cek izin tulis folder data/.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
  <h1>Buat akun</h1>
  <?php foreach ($errors as $err): ?>
    <div class="pesan error"><?= bersih($err) ?></div>
  <?php endforeach; ?>
  <form method="post" novalidate>
    <label for="nama">Nama</label>
    <input type="text" id="nama" name="nama" value="<?= bersih($nama) ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= bersih($email) ?>" required>

    <label for="password">Password (min. 8 karakter)</label>
    <input type="password" id="password" name="password" required>

    <label for="konfirmasi">Konfirmasi password</label>
    <input type="password" id="konfirmasi" name="konfirmasi" required>

    <button type="submit">Daftar</button>
  </form>
  <p class="alt">Sudah punya akun? <a href="login.php">Login</a></p>
</main>
</body>
</html>
