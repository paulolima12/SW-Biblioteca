<?php
session_start();
require('conexao.php');

// Dados do formulário
$cpf_cadastro = $_POST['cpf_cadastro'];
$nome_cadastro = $_POST['nome_cadastro'];
$email_cadastro = $_POST['email_cadastro'];
$senha_cadastro = hash('sha256', md5($_POST['senha_cadastro'])); // Criptografar a senha

// Verificar se o email OU o CPF já existem no banco de dados
$sql_verifica = "SELECT * FROM usuario WHERE email = '$email_cadastro' OR cpf = '$cpf_cadastro'";
$resultado_verifica = $conexao->query($sql_verifica);

if ($resultado_verifica->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Email ou CPF já cadastrados.'); window.location.href='cadastro.html';</script>";
    exit();
}

// Inserir o usuário no banco de dados
$sql = "INSERT INTO usuario (nome, cpf, senha, email) VALUES ('$nome_cadastro', '$cpf_cadastro', '$senha_cadastro', '$email_cadastro')";
if ($conexao->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Cadastro realizado com sucesso!'); window.location.href='login.php';</script>";
    exit();
} else {
    echo "Erro: " . $conexao->error;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Biblioteca Online</title>
    <style>
        /* Define a imagem de fundo */
        body {
            background-image: url("img/biblioteca_leonardo.jpg"); /* Caminho para a sua imagem de fundo */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Estilo do container de cadastro */
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Fundo semi-transparente */
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Estilo dos campos de entrada */
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        /* Estilo do botão */
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form action="seu_arquivo_cadastro.php" method="POST">
            <input type="text" name="cpf_cadastro" placeholder="CPF" required>
            <input type="text" name="nome_cadastro" placeholder="Nome Completo" required>
            <input type="email" name="email_cadastro" placeholder="Email" required>
            <input type="password" name="senha_cadastro" placeholder="Senha" required>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>
