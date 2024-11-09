<?php

session_start();
include '../conexao.php';

if ((!isset($_SESSION['id_usuario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);
    header('Location: ../index.html');
}

$id_usuario = $_SESSION['id_usuario'];
$status = $_SESSION['status'];
$id_livro = $_POST['id_livro'];
$data_emprestimo = $_POST['data_emprestimo'];
$data_devolucao = $_POST['data_devolucao'];

if ($status == 'bloqueado') {
    echo "<script>alert('Você está bloqueado, verifique a devolução de seus empréstimos e tente novamente.'); window.location.href='livros.php';</script>";
    exit();
}

$sql = "INSERT INTO emprestimo (id_livro, id_usuario, data_emprestimo, data_devolucao, `status`, status_devolucao) 
        VALUES ($id_livro, $id_usuario, '$data_emprestimo', '$data_devolucao', 'solicitado', 'aguardando confirmação')";
        
if ($conexao->query($sql) === TRUE) {
    echo "<script>alert('Empréstimo solicitado com sucesso!'); window.location.href='livros.php';</script>";
} else {
    echo "<script>alert('Erro ao solicitar o empréstimo. Tente novamente.'); window.location.href='livro_selecionado.php?id_livro=$id_livro';</script>";
}