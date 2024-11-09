<?php
session_start();
require('conexao.php');

$email_login = $_POST['email_login'];
$senha_login = hash('sha256', md5($_POST['senha_login'])); // Criptografia da senha

$consulta_usuario = "SELECT * FROM usuario WHERE email = '$email_login' AND senha = '$senha_login'";
$resultado_usuario = $conexao->query($consulta_usuario);

if ($resultado_usuario && $resultado_usuario->num_rows == 1) {
    $resultado_usuario_dados = $resultado_usuario->fetch_assoc();
    $_SESSION['id_usuario'] = $resultado_usuario_dados['id_usuario'];
    $_SESSION['nome'] = $resultado_usuario_dados['nome'];
    $_SESSION['email'] = $resultado_usuario_dados['email'];
    header('Location: pages/livros.php');
    exit();
}

$consulta_funcionario = "SELECT * FROM funcionario WHERE email = '$email_login' AND senha = '$senha_login'";
$resultado_funcionario = $conexao->query($consulta_funcionario);

if ($resultado_funcionario && $resultado_funcionario->num_rows == 1) {
    $resultado_funcionario_dados = $resultado_funcionario->fetch_assoc();

    if ($resultado_funcionario_dados['status'] == 'inativo') {
        echo "<script type='text/javascript'>alert('Sua conta de funcionário está inativa no sistema. Faça contato com um administrador para saber mais.'); window.location.href='index.html';</script>";
        exit();
    };

    $_SESSION['id_funcionario'] = $resultado_funcionario_dados['id_funcionario'];
    $_SESSION['nome'] = $resultado_funcionario_dados['nome'];
    $_SESSION['email'] = $resultado_funcionario_dados['email'];
    header('Location: dashboard-func/index.php');
    exit();
}

$consulta_administrador = "SELECT * FROM administrador WHERE email = '$email_login' AND senha = '$senha_login'";
$resultado_administrador = $conexao->query($consulta_administrador);

if ($resultado_administrador && $resultado_administrador->num_rows == 1) {
    $resultado_administrador_dados = $resultado_administrador->fetch_assoc();
    $_SESSION['id_adm'] = $resultado_administrador_dados['id_adm'];
    $_SESSION['nome'] = $resultado_administrador_dados['nome'];
    $_SESSION['email'] = $resultado_administrador_dados['email'];
    header('Location: dashboard-admin/index.php');
    exit();
} else {
    // Redirecionar para o login com msg de erro
    echo "<script type='text/javascript'>alert('Email ou senha incorretos.'); window.location.href='login.php';</script>";
    exit();
}
