<?php
// ===== Fungsi bersama untuk semua halaman =====
session_start();

define('FILE_USER', __DIR__ . '/data/users.json');

// Sanitasi input/output (requirement 9)
function bersih(string $teks): string {
    return htmlspecialchars(trim($teks), ENT_QUOTES, 'UTF-8');
}

// Baca semua user dari file JSON
function ambilUsers(): array {
    if (!file_exists(FILE_USER)) return [];
    $data = json_decode(file_get_contents(FILE_USER), true);
    return is_array($data) ? $data : [];
}

// Simpan user ke file JSON (dengan file lock agar aman)
function simpanUsers(array $users): bool {
    $json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents(FILE_USER, $json, LOCK_EX) !== false;
}

// Cari user berdasarkan email (return null jika tidak ada)
function cariUser(string $email): ?array {
    foreach (ambilUsers() as $u) {
        if ($u['email'] === $email) return $u;
    }
    return null;
}

// Pesan sekali tampil (flash message)
function setPesan(string $tipe, string $isi): void {
    $_SESSION['pesan'] = ['tipe' => $tipe, 'isi' => $isi];
}
function tampilPesan(): void {
    if (!empty($_SESSION['pesan'])) {
        $p = $_SESSION['pesan'];
        echo '<div class="pesan ' . bersih($p['tipe']) . '">' . bersih($p['isi']) . '</div>';
        unset($_SESSION['pesan']);
    }
}

function sudahLogin(): bool {
    return isset($_SESSION['user_id']);
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}
