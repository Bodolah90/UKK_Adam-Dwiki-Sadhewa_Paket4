<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: user/dashboard.php');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Halaman</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="login-container">
        <form action="proses_login.php" method="post" class="login-form">
            <h2>Silakan Login</h2>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login">Login</button>

            <p>
                Belum punya akun?
                <a href="register.php">Daftar</a>
            </p>

        </form>
    </div>
</body>

</html>