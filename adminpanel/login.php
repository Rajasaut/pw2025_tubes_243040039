<?php
session_start();
include "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek user di database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION['login'] = $username;
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
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
    <link rel="stylesheet" href="../css/style.css" />
</head>


<body>
    <div class="login-container">
        <h2>Yayasan peduli</h2>
        <h3>Bersama kita dari yayasan untuk mereka yang membutuhkan.
        </h3>
        <?php if ($error) {
            echo "<p class='error'>$error</p>";
        } ?>

        <form method="POST" action="">
            <div class="untuk-input">
                <label>Username :</label>
                <input type="text" name="username" required />
                <label>Password :</label>
                <input type="password" name="password" required />
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>