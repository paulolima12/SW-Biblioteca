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


