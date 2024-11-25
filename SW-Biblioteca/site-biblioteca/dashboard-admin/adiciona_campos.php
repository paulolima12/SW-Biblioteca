<?php
session_start();

if ((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_adm']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$caracteres_sem_acento = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Â'=>'Z', 'Â'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'Å'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'Å'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    'Ä'=>'a', 'È'=>'s', 'È'=>'t', 'Ä'=>'A', 'È'=>'S', 'È'=>'T',
);

$genero = $_POST['genero'];
$autor = $_POST['autor'];
$editora = $_POST['editora'];

if (isset($genero) && !isset($autor) && !isset($editora)) {
    $genero_formatado = strtolower(strtr($genero, $caracteres_sem_acento)); 

    $sql_genero = "SELECT * FROM genero WHERE genero.genero COLLATE utf8mb4_general_ci = '$genero_formatado'";
    $resultado_genero = $conexao->query($sql_genero);

    if ($resultado_genero->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Esse gênero já está cadastrado no banco de dados.'); window.location.href='form_cadastro_genero.php';</script>";
        exit();
    } else {
        $sql_cadastro_genero = "INSERT INTO genero (genero) values ('$genero')";
        $resultado_cadastro_genero = $conexao->query($sql_cadastro_genero);
        echo "<script type='text/javascript'>alert('O gênero de livro foi adicionado com sucesso.'); window.location.href='form_cadastro_genero.php';</script>";
        exit();
    }
}

if (isset($autor) && !isset($genero) && !isset($editora)) {
    $autor_formatado = strtolower(strtr($autor, $caracteres_sem_acento)); 

    $sql_autor = "SELECT * FROM autor WHERE autor.nome COLLATE utf8mb4_general_ci = '$autor_formatado'";
    $resultado_autor = $conexao->query($sql_autor);

    if ($resultado_autor->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Esse autor já está cadastrado no banco de dados.'); window.location.href='form_cadastro_autor.php';</script>";
        exit();
    } else {
        $sql_cadastro_autor = "INSERT INTO autor (nome) values ('$autor')";
        $resultado_cadastro_autor = $conexao->query($sql_cadastro_autor);
        echo "<script type='text/javascript'>alert('O autor foi adicionado com sucesso.'); window.location.href='form_cadastro_autor.php';</script>";
        exit();
    }
}

if (isset($editora) && !isset($autor) && !isset($genero)) {
    $editora_formatado = strtolower(strtr($editora, $caracteres_sem_acento)); 

    $sql_editora = "SELECT * FROM editora WHERE editora.editora COLLATE utf8mb4_general_ci = '$editora_formatado'";
    $resultado_editora = $conexao->query($sql_editora);

    if ($resultado_editora->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Essa editora já está cadastrada no banco de dados.'); window.location.href='form_cadastro_editora.php';</script>";
        exit();
    } else {
        $sql_cadastro_editora = "INSERT INTO editora (editora) values ('$editora')";
        $resultado_cadastro_editora = $conexao->query($sql_cadastro_editora);
        echo "<script type='text/javascript'>alert('A editora de livros foi adicionado com sucesso.'); window.location.href='form_cadastro_editora.php';</script>";
        exit();
    }
}
