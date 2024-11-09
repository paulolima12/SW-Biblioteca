<?php

session_start();
require('../conexao.php');

$id_funcionario = $_GET['id_funcionario'];

$sql = "SELECT `status` FROM funcionario WHERE id_funcionario = $id_funcionario";
$consulta = $conexao->query($sql);
$dados = $consulta->fetch_assoc();

if ($dados['status'] === 'ativo') {
    $sql_ativo = "UPDATE funcionario SET `status` = 'inativo' WHERE id_funcionario = $id_funcionario";
    $consulta_ativo = $conexao->query($sql_ativo);
    header('Location: index_funcionarios.php');
    exit();
} else if ($dados['status'] === "inativo") {
    $sql_inat = "UPDATE funcionario SET `status` = 'ativo' WHERE id_funcionario = $id_funcionario";
    $consulta_inat = $conexao->query($sql_inat);
    header('Location: index_funcionarios.php');
    exit();
}