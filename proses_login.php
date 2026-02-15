<?php
session_start();
include 'config/config.php';  // $koneksi atau $conn

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];  // Password tak escape, verify hash nanti

    // Query langsung dengan escape
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) {

            // Session umum
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Session spesifik untuk user
            if ($user['role'] == 'user') {
                $_SESSION['user_id'] = $user['id'];   // Hanya untuk user
                header('Location: user/dashboard.php');
            } else if ($user['role'] == 'admin') {
                $_SESSION['id'] = $user['id'];  // Hanya untuk admin
                header('Location: admin/dashboard.php');
            }

            exit();
        }
    }
    echo "Username atau password salah! <a href='index.php'>Coba lagi</a>";
}
