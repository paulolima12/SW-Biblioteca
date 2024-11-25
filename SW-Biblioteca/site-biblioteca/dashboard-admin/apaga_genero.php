<?php
session_start();

if ((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_adm']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$id_genero = $_GET['id_genero'];

if (!$id_genero) {
    echo "<script type='text/javascript'>alert('ID do gênero não informado.'); window.location.href='form_cadastro_genero.php';</script>";
    exit();
}

$sql = "SELECT * FROM livro WHERE livro.id_genero = '$id_genero'";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Esse gênero de livro está atribuído a algum livro e não pode ser deletado do banco de dados.'); window.location.href='form_cadastro_genero.php';</script>";
    exit();
} else {
    $sql_delete = "DELETE FROM genero WHERE genero.id_genero = '$id_genero'";
    $resultado_delete = $conexao->query($sql_delete);
    echo "<script type='text/javascript'>alert('O gênero de livro foi deletado com sucesso.'); window.location.href='form_cadastro_genero.php';</script>";
    exit();
}