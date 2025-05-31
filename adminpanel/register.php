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
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <!-- bagian resgistrasi -->
    <div class="login-container">
        <h2>Halaman Registrasi</h2>

        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

        <form action="" method="post">
            <div class="untuk-input">
                <label for="username">Username :</label>
                <input type="text" name="username" id="username" required />
                <label for="password">Password :</label>
                <input type="password" name="password" id="password" required />
                <label for="password2">Konfirmasi Password :</label>
                <input type="password" name="password2" id="password2" required />
            </div>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>

</html>