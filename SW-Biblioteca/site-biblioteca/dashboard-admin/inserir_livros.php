<?php

session_start();
require('../conexao.php');

$isbn = $_POST['isbn'];
$titulo = $_POST['titulo'];
$ano_publicacao = $_POST['ano_publicacao'];
$id_editora = $_POST['id_editora'];
$id_genero = $_POST['id_genero'];
$id_autor = $_POST['id_autores']; 
$capa = $_POST['capa'];

// Verificar se o ISBN já existe no banco 
$sql_verifica = "SELECT * FROM livro WHERE isbn = '$isbn'";
$resultado_verifica = $conexao->query($sql_verifica);

if ($resultado_verifica->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Já existe um livro com esse ISBN.'); window.location.href='index.php';</script>";
    exit();
}

// Inserir o livro no banco de dados
$sql = "INSERT INTO livro (isbn, titulo, ano_publicacao, id_editora, id_genero, `status`, capa) 
        VALUES ('$isbn', '$titulo', '$ano_publicacao', '$id_editora', '$id_genero', 'disponível', '$capa')";

if ($conexao->query($sql) === TRUE) {
    $id_livro = $conexao->insert_id; // Pega o id do livro 

    // Inserir o id_autor e id_livro na tabela livro_autor
    $sql_autor = "INSERT INTO livro_autor (id_livro, id_autor) VALUES ('$id_livro', '$id_autor')";
    $conexao->query($sql_autor);

    echo "<script type='text/javascript'>alert('Livro adicionado com sucesso!'); window.location.href='index.php';</script>";
    exit();
} else {
    echo "Erro: " . $conexao->error;
}

