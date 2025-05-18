<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>

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
        <h2>Selamat Datang Di Bengkel Motor Sosial </h2>
        <h3>(Pelatihan & Layanan Gratis untuk Masyarakat)</h3>
        <img src="" alt="" class="">
        <a href="logout.php"><button>Logout</button></a>
    </div>
</body>

</html>