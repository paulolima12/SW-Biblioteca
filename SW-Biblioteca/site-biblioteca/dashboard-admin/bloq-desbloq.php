<?php

session_start();
require('../conexao.php');

$id_usuario = $_GET['id_usuario'];

$sql = "SELECT `status` FROM usuario WHERE id_usuario = $id_usuario";
$consulta = $conexao->query($sql);
$dados = $consulta->fetch_assoc();

if ($dados['status'] === 'ativo') {
    $sql_ativo = "UPDATE usuario SET `status` = 'bloqueado' WHERE id_usuario = $id_usuario";
    $consulta_ativo = $conexao->query($sql_ativo);
    header('Location: index_usuarios.php');
    exit();
} else if ($dados['status'] === "bloqueado") {
    $sql_bloq = "UPDATE usuario SET `status` = 'ativo' WHERE id_usuario = $id_usuario";
    $consulta_bloq = $conexao->query($sql_bloq);
    header('Location: index_usuarios.php');
    exit();
}