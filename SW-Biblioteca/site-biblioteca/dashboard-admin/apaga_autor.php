<?php
session_start();

if ((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_adm']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$id_autor = $_GET['id_autor'];

if (!$id_autor) {
    echo "<script type='text/javascript'>alert('ID do autor não informado.'); window.location.href='form_cadastro_autor.php';</script>";
    exit();
}

$sql = "SELECT * FROM livro_autor WHERE livro_autor.id_autor = '$id_autor'";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Esse autor está atribuído a algum livro e não pode ser deletado do banco de dados.'); window.location.href='form_cadastro_autor.php';</script>";
    exit();
} else {
    $sql_delete = "DELETE FROM autor WHERE autor.id_autor = '$id_autor'";
    $resultado_delete = $conexao->query($sql_delete);
    echo "<script type='text/javascript'>alert('O autor foi deletado com sucesso.'); window.location.href='form_cadastro_autor.php';</script>";
    exit();
}