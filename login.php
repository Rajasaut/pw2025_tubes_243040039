<?php
session_start();
include "./adminpanel/koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek user di database
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hash, $role);
        $stmt->fetch();

        // Untuk membedakan login ke user dan admin
        if (password_verify($password, $hash)) {
            $_SESSION['login'] = $username;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: ./adminpanel/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Username / Password salah";
        }
    } else {
        $error = "Username / Password salah";
    }


    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css" />
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
    <!-- bagian untuk banner -->
    <header>
        <h2 class="logo">Login</h2>
        <nav class="navigation">
            <button type="btnlogin-popup" class="btnlogin-popup">Login</button>
        </nav>

    </header>


    <div class="login-container active-popup">
        <!-- <img src="./img/logo1.png" alt=""> -->
        <h2 class="text-center">Login</h2>
        <span class="icon-close"><i class="bi bi-x"></i></span>
        <?php if ($error) {
            echo "<p class='error'>$error</p>";
        } ?>
        <form method="POST" action="">
            <div class="untuk-input">
                <span class="icon"><i class="bi bi-person-fill"></i></span>
                <input type="text" name="username" required />
                <label>Username</label>
            </div>
            <div class="untuk-input">
                <span class="icon"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password" required />
                <label>Password</label>
                </span>
            </div>
            <button type="submit" class="fw-bold">Login</button>
            <p class="text-center mt-5">Belum punya akun? <a href="register.php" class="text-center"> Daftar di sini</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>