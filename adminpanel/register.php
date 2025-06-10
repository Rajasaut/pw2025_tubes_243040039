<?php
session_start();
include "koneksi.php";

// ker nampilken pesan error atau sukses
$error = "";
$success = "";

if (isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $password2 = $_POST["password2"];



    if ($username == "" || $password == "" || $password2 == "") {
        $error = "Semua kolom harus diisi!";
    } elseif ($password !== $password2) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Untuk ngcek username/paswod sudah ada atau belum
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            // Untuk Simpan ke database
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Gagal menyimpan data, coba lagi.";
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css" />
</head>
<!-- bagian java script  -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btnpopup = document.querySelector('.btnlogin-popup');
        const loginContainer = document.querySelector('.login-container');
        const iconClose = document.querySelector('.icon-close');

        btnpopup.addEventListener('click', () => {
            loginContainer.classList.add('active-popup');
        });
        iconClose.addEventListener('click', () => {
            loginContainer.classList.remove('active-popup');
        });
    });
</script>

<body>
    <header>
        <h2 class="logo">Login</h2>
        <nav class="navigation">
            <button type="btnlogin-popup" class="btnlogin-popup">Login</button>
        </nav>

    </header>
    <!-- bagian resgistrasi -->
    <div class="login-container">
        <h2 class="text-center ">Halaman Registrasi</h2>
        <span class="icon-close"><i class="bi bi-x"></i></span>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <form action="" method="post">
            <div class="untuk-input">
                <span class="icon"><i class="bi bi-person-fill"></i></span>
                <input type="text" name="username" id="username" required />
                <label>Username :</label>
            </div>
            <div class="untuk-input">
                <span class="icon"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password" id="password" required />
                <label>Password :</label>
            </div>
            <div class="untuk-input">
                <span class="icon"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password2" id="password2" required />
                <label>Konfirmasi Password :</label>
            </div>
            <button type="submit" name="register" class="fw-bold">Register</button>
            <p class="text-center mt-1">Sudah punya akun? <a href="login.php" class="text-center">Login di sini</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>