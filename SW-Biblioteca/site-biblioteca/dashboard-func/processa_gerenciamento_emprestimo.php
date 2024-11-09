<?php

session_start();
require('../conexao.php');

$id_emprestimo = $_POST['id_emprestimo'];
$acao = $_POST['acao'];

$sql = "SELECT `status`, status_devolucao, id_livro, id_usuario FROM emprestimo WHERE id_emprestimo = $id_emprestimo";
$resultado = $conexao->query($sql);
$dados = $resultado->fetch_assoc();

if ($acao == 'aceitar_devolucao' && $dados['status_devolucao'] === 'pendente') {
    $sql = "UPDATE emprestimo SET status_devolucao = 'confirmada', `status` = 'concluído', WHERE id_emprestimo = $id_emprestimo;
            UPDATE livro SET status = 'disponível' WHERE id_livro = {$dados['id_livro']}";
    $conexao->multi_query($sql);
    echo "<script>alert('Devolução confirmada e empréstimo concluído.');</script>";
} elseif ($acao == 'rejeitar_devolucao' && $dados['status_devolucao'] === 'pendente') {
    $sql = "UPDATE emprestimo SET status_devolucao = 'atrasada', status = 'em andamento' WHERE id_emprestimo = $id_emprestimo;
            UPDATE usuario SET `status` = 'bloqueado' WHERE id_usuario = {$dados['id_usuario']}";
    $conexao->multi_query($sql);
    echo "<script>alert('Devolução rejeitada e usuário bloqueado.');</script>";
} else if ($acao == 'aceitar_devolucao_atrasada' && $dados['status_devolucao'] === 'atrasada') {
    $sql = "UPDATE emprestimo SET status_devolucao = 'confirmada', status = 'concluído' WHERE id_emprestimo = $id_emprestimo;
            UPDATE usuario SET status = 'ativo' WHERE id_usuario = {$dados['id_usuario']};
            UPDATE livro SET status = 'disponível' WHERE id_livro = {$dados['id_livro']}";
    $conexao->multi_query($sql);
    echo "<script>alert('Devolução rejeitada e usuário bloqueado.');</script>";
}

header("Location: gerencia-emprestimos.php?id_emprestimo=$id_emprestimo");
exit();

