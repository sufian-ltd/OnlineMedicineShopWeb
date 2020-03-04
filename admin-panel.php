<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;">
<?php include "includes/admin-navbar.php";?>
<img src="images/adminpanel.jpg" style="width: 100%;height: 600px;">
<?php //include "includes/slider.php" ?>
<?php include "includes/footer.php" ?>
</body>
</html>
