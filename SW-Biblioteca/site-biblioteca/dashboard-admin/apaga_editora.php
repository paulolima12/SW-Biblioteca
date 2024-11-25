<?php
session_start();

if ((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_adm']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$id_editora = $_GET['id_editora'];

if (!$id_editora) {
    echo "<script type='text/javascript'>alert('ID da editora não informado.'); window.location.href='form_cadastro_editora.php';</script>";
    exit();
}

$sql = "SELECT * FROM livro WHERE livro.id_editora = '$id_editora'";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Essa editora está atribuída a algum livro e não pode ser deletada do banco de dados.'); window.location.href='form_cadastro_editora.php';</script>";
    exit();
} else {
    $sql_delete = "DELETE FROM editora WHERE editora.id_editora = '$id_editora'";
    $resultado_delete = $conexao->query($sql_delete);
    echo "<script type='text/javascript'>alert('A editora foi deletada com sucesso.'); window.location.href='form_cadastro_editora.php';</script>";
    exit();
}