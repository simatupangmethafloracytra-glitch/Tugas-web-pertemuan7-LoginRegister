<?php
require 'functions.php';
if (sudahLogin()) redirect('dashboard.php');

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Email dan password wajib diisi.';
    } else {
        $user = cariUser($email);
        // password_verify() membandingkan password dengan hash
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);          // cegah session fixation
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['email']   = $user['email'];
            setPesan('sukses', 'Login berhasil. Selamat datang!');
            redirect('dashboard.php');
        }
        $error = 'Email atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
  <h1>Login</h1>
  <?php tampilPesan(); ?>
  <?php if ($error): ?>
    <div class="pesan error"><?= bersih($error) ?></div>
  <?php endif; ?>
  <form method="post" novalidate>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= bersih($email) ?>" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Masuk</button>
  </form>
  <p class="alt">Belum punya akun? <a href="register.php">Daftar</a></p>
</main>
</body>
</html>
