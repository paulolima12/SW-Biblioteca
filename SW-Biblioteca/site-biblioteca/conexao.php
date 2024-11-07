<?php 

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "biblioteca";

    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    mysqli_set_charset($conexao,"utf8");

    if (mysqli_connect_errno()) {
        echo "Erro na conexão";
    }
    
?>
