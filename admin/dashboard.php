<?php
session_start();
include '../config/config.php';  // Path naik satu level ke config/

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard_admin.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <h1>Selamat datang, Admin <?php echo $_SESSION['username']; ?>!</h1>
    <!-- Konten admin -->
</body>

</html>