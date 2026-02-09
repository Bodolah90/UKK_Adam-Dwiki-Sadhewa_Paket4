<?php
include 'config/config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // TANPA hash (sesuai sistem kamu)
    $role = 'user';

    // Cek username
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
    } else {
        // Simpan user
        $query = "INSERT INTO users (username, password, role)
                  VALUES ('$username', '$password', '$role')";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>
                alert('Register berhasil! Silakan login');
                window.location='index.php';
            </script>";
        } else {
            echo "<script>alert('Register gagal');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <form method="post" class="login-form">
            <h2>Register User</h2>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="register">Register</button>

            <p>
                Sudah punya akun?
                <a href="index.php">Login</a>
            </p>
        </form>
    </div>
</body>

</html>