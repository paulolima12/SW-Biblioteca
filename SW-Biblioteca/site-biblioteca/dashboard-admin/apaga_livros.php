<?php
session_start();

if ((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_adm']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$id_livro = $_GET['id_livro'];


$sql_excluir_emprestimos = "DELETE FROM emprestimo WHERE id_livro = $id_livro";
$conexao->query($sql_excluir_emprestimos);

$sql_excluir_associacoes = "DELETE FROM livro_autor WHERE id_livro = $id_livro";
$query_associacoes = $conexao->query($sql_excluir_associacoes);

$sql_excluir_livro = "DELETE FROM livro WHERE id_livro = $id_livro";
$query_livro = $conexao->query($sql_excluir_livro);

// Redireciona para a página de listagem de livros após a exclusão
header('Location: index.php');



