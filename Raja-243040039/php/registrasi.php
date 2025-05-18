<?php
session_start();
$error = "";
$success = "";

if (isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    // Validasi kosong
    if ($username == "" || $password == "" || $password2 == "") {
        $error = "Semua kolom harus diisi!";
    } elseif ($password !== $password2) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah file user sudah ada
        $file = "users.txt";
        $users = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];

        // Cek apakah username sudah digunakan
        foreach ($users as $user) {
            $data = explode("|", $user);
            if ($data[0] == $username) {
                $error = "Username sudah terdaftar!";
                break;
            }
        }

        if (!$error) {
            // Simpan username|password_hash ke file
            $hash = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents($file, "$username|$hash\n", FILE_APPEND);
            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <h2>Halaman Registrasi</h2>

        <!-- Tampilkan pesan -->
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

        <form action="" method="post">
            <div class="untuk-input">
                <label for="username">Username :</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password :</label>
                <input type="password" name="password" id="password" required>
                <label for="password2">Konfirmasi Password :</label>
                <input type="password" name="password2" id="password2" required>
            </div>
            <button type="submit" name="register">Register</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>

</html>