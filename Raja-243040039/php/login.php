<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $file = "users.txt";
    if (file_exists($file)) {
        $users = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($saved_user, $saved_hash) = explode("|", $user);
            if ($username == $saved_user && password_verify($password, $saved_hash)) {
                $_SESSION['login'] = $username;
                // header("Location: admin.php");
                header("Location: registrasi.php");
                exit();
            }
        }
    }
    $error = "Username / Password salah";
} else {
    $error = "Username / Password salah";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <img src="" alt="" class="">
        <h2>Masuk ke Bengkel Motor Sosial</h2>
        <?php if ($error) {
            echo "<p class='error'>$error</p>";
        } ?>
        <form method="POST">
            <div class="untuk-input">
                <label>Username :</label>
                <input type="text" name="username" required><br>
                <label>Password :</label>
                <input type="password" name="password" required><br>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>