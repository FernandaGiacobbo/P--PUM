<?php
session_start();
if(isset($_GET['id_usuario'])){

    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['id']);
    unset($_SESSION['senha']);

    header('location: index.php');
} else {
    header('location: principal.php');
    die();
}
?>