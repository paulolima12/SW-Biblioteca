<?php 

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "biblioteca";

    $conexao = new mysqli($servidor, $usuario, $senha, $banco);

    if (mysqli_connect_errno()) {
        echo "Erro na conexão";
    }
    
?>
