<?php
session_start();
if (isset($_SESSION['USER']) == "admin") {
	unset($_SESSION['USER']);
    header('Location: index.php');
    exit();
}
?>