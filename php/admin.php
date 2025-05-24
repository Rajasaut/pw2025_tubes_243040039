<?php
// untuk menu yg sudah bisa login
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>

<!-- Untuk menampilkan halaman admin dengan pesan sambutan dan tombol logout. -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="admin-container">
        <h1>🌱</h1>
        <h2>Selamat Datang Di Lingkungan dan Keberlanjutan</h2>
        <h3> Platform Keren Buat yang Mau Menjaga Alam</h3>
        <img src="" alt="" class="">
        <a href="logout.php"><button>Logout</button></a>
    </div>
</body>

</html>