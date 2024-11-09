<?php
session_start();
require('../conexao.php');

$id_emprestimo = $_GET['id_emprestimo'];
$acao = $_GET['acao'];
$id_livro = $_GET['id_livro'];

if ($acao == 'aprova') {
    $sql = "UPDATE emprestimo SET `status` = 'em andamento', id_funcionario = {$_SESSION['id_funcionario']} WHERE id_emprestimo = $id_emprestimo;
            UPDATE livro SET `status` = 'emprestado' WHERE id_livro = $id_livro";

    if ($conexao->multi_query($sql) === TRUE) {
        echo "<script>alert('Empréstimo aprovado com sucesso!'); window.location.href='index_emprestimos.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao aprovar o empréstimo.'); window.location.href='index_emprestimos.php';</script>";
        exit();
    }

} else if ($acao == 'rejeita') {
    $sql = "UPDATE emprestimo SET `status` = 'rejeitado', id_funcionario = {$_SESSION['id_funcionario']} WHERE id_emprestimo = $id_emprestimo";
    
    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Empréstimo rejeitado com sucesso!'); window.location.href='index_emprestimos.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao rejeitar o empréstimo.'); window.location.href='index_emprestimos.php';</script>";
        exit();
    }
}
