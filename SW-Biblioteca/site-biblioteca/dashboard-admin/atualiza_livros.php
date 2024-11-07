<?php

session_start();
require('../conexao.php');

$id_livro = $_POST['id_livro'];
$isbn_atual = $_POST['isbn_atual'];

if (isset($_POST['titulo']) && isset($_POST['isbn']) && isset($_POST['id_autor'])) {
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $id_editora = $_POST['id_editora'];
    $id_genero = $_POST['id_genero'];
    $id_autor = $_POST['id_autor'];

    if ($isbn !== $isbn_atual) {
        $sql_verifica = "SELECT 1 FROM livro WHERE isbn = '$isbn' AND id_livro != '$id_livro'";
        $resultado_verifica = $conexao->query($sql_verifica);

        if ($resultado_verifica->num_rows > 0) {
            echo "<script type='text/javascript'>alert('Já existe um livro com esse ISBN.'); window.location.href='index.php';</script>";
            exit();
        }
    }

    $sql = "UPDATE livro SET 
                isbn = '$isbn', 
                titulo = '$titulo', 
                ano_publicacao = '$ano_publicacao', 
                id_editora = '$id_editora', 
                id_genero = '$id_genero'
            WHERE id_livro = '$id_livro'";

    if ($conexao->query($sql) === TRUE) {
        $sql_verifica_autor = "SELECT id_autor FROM livro_autor WHERE id_livro = '$id_livro'";
        $resultado_verifica_autor = $conexao->query($sql_verifica_autor);
        $autor_atual = $resultado_verifica_autor->fetch_assoc()['id_autor'];

        if ($autor_atual != $id_autor) {
            $sql_autor = "UPDATE livro_autor SET id_autor = '$id_autor' WHERE id_livro = '$id_livro'";
            if (!$conexao->query($sql_autor)) {
                echo "Erro ao atualizar autor: " . $conexao->error;
                exit();
            }
        }

        echo "<script type='text/javascript'>alert('Livro atualizado com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "Erro ao atualizar livro: " . $conexao->error;
    }
}

