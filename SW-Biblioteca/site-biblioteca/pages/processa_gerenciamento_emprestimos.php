<?php

session_start();
require('../conexao.php');

$id_emprestimo = $_POST['id_emprestimo'];
$acao = $_POST['acao'];

$sql = "SELECT `status`, status_devolucao, id_livro FROM emprestimo WHERE id_emprestimo = $id_emprestimo;";
$resultado = $conexao->query($sql);
$dados = $resultado->fetch_assoc();

if ($acao == 'confirmar_devolucao' && $dados['status_devolucao'] == 'aguardando confirmação' OR $dados['status_devolucao'] == 'atrasada') {
    $sql = "UPDATE emprestimo SET status_devolucao = 'pendente' WHERE id_emprestimo = $id_emprestimo;";
    $conexao->multi_query($sql);
    echo "<script type='text/javascript'>alert('Devolução confirmada, espere o funcionário aprovar para o empréstimo ser finalizado.'); window.location.href='index.php';</script>";
} 

header("Location: gerencia_emprestimo.php?id_emprestimo=$id_emprestimo");
exit();

