<?php 
    session_start();

    unset($_SESSION['id_funcionario'], $_SESSION['nome'], $_SESSION['email']);
    header('Location: ../index.html');
?>