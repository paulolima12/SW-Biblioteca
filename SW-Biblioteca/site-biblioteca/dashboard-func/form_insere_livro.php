<?php
session_start();
require('../conexao.php');

$p = $conexao->prepare("INSERT INTO livro(isbn, titulo, ano_publicacao, id_editora, id_genero, status) values ('" . $_POST['isbn'] . "','" . $_POST['titulo'] . "'," . $_POST['ano_publicacao'] . ",'1','1','disponível')");
$p->execute();

header('Location: index.php');
