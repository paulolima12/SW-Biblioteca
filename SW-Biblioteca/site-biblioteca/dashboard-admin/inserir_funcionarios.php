<?php

session_start();
require('../conexao.php');

$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$sql_verifica = "SELECT cpf, email FROM funcionario WHERE cpf = '$cpf' OR email = '$email'
                UNION
                SELECT cpf, email FROM usuario WHERE cpf = '$cpf' OR email = '$email'
                UNION
                SELECT cpf, email FROM administrador WHERE cpf = '$cpf' OR email = '$email'";

$resultado_verifica = $conexao->query($sql_verifica);

if ($resultado_verifica->num_rows > 0) {
    echo "<script type='text/javascript'>alert('CPF ou email já cadastrado.'); window.location.href='index_funcionarios.php';</script>";
    exit();
}

$senha_criptografada = hash('sha256',  md5($senha));

// Inserir o livro no banco de dados
$sql = "INSERT INTO funcionario (cpf, nome, email, senha, `status`) 
        VALUES ('$cpf', '$nome', '$email', '$senha_criptografada', 'ativo')";

$conexao->query($sql);

mail($email, "Cadastro de funcionário", "Sua senha de acesso é: $senha");
echo "<script type='text/javascript'>alert('Cadastro realizado. Anote a senha e informe o funcionário. Senha: ". $senha ."'); window.location.href='index_funcionarios.php';</script>";
exit();