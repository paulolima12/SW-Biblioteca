<?php

include '../conexao.php';

$id_livroSelecionado = $_REQUEST['id_livro'];

$sql_excluir_associacoes = "DELETE FROM livro_autor WHERE id_livro = $id_livroSelecionado";
$query_associacoes = $conexao->query($sql_excluir_associacoes);

$sql_excluir_livro = "DELETE FROM livro WHERE id_livro = $id_livroSelecionado";
$query_livro = $conexao->query($sql_excluir_livro);

// Redireciona para a página de listagem de livros após a exclusão
header('Location: index.php');



