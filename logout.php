<?php
require 'functions.php';
$_SESSION = [];
session_destroy();           // hapus session
session_start();             // mulai session baru hanya untuk pesan
setPesan('sukses', 'Kamu berhasil logout.');
redirect('login.php');
