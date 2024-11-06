<?php 
<link href="css/styles.css" rel="stylesheet" />

    session_start();

    unset($_SESSION['id_adm'], $_SESSION['nome'], $_SESSION['email']);
    header('Location: ../index.html');
