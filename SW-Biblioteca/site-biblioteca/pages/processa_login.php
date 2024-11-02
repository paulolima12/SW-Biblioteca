<?php

session_start();
require('conexao.php');

$email_login = $_POST['email_login'];
$senha_login = md5($_POST['senha_login']); // Criptografia da senha

function verificar_login($conexao, $email, $senha, $tipo){
    $consulta = "SELECT * FROM $tipo WHERE email = '$email' AND senha = '$senha'";
    return $conexao->query($consulta);
}

// Verifica os tipo de usuários
$tipos = ['usuario', 'funcionario', 'administrador'];
$usuario_encontrado = null;

foreach ($tipos as $tipo) {
    $resultado = verificar_login($conexao, $email_login, $senha_login, $tipo);
    if ($resultado->num_rows == 1) {
        $usuario_encontrado = mysqli_fetch_assoc($resultado);
        $usuario_encontrado['tipo'] = $tipo; // Adiciona o tipo ao array do usuário
        break; // Encerra o loop se um usuário foi encontrado
    }
}

// ID da session para cada tipo de usuário
if ($usuario_encontrado) {
    // Armazena dados na session
    switch ($usuario_encontrado['tipo']) {
        case 'usuario':
            $_SESSION['id_usuario'] = $usuario_encontrado['id'];
            break;
        case 'funcionario':
            $_SESSION['id_funcionario'] = $usuario_encontrado['id'];
            break;
        case 'administrador':
            $_SESSION['id_adm'] = $usuario_encontrado['id'];
            break;
    }
    $_SESSION['nome'] = $usuario_encontrado['nome'];
    $_SESSION['email'] = $usuario_encontrado['email'];

    // Redirecionamento de páginas baseado no tipo de usuário (usuario, funcionario, administrador)
    switch ($usuario_encontrado['tipo']) {
        case 'usuario':
            header('Location: menunav.html');
            break;
        case 'funcionario':
            header('Location: dashboard-funcionario.html');
            break;
        case 'administrador':
            header('Location: dashboard-admin.html');
            break;
        default:
            echo "<script type='text/javascript'>alert('Tipo de usuário inválido.'); window.location.href='login.html';</script>";
            break;
    }
    exit();
} else {
    // Redirecionar de volta para o login com mensagem de erro
    echo "<script type='text/javascript'>alert('Email ou senha incorretos.'); window.location.href='login.html';</script>";
    exit();
}

