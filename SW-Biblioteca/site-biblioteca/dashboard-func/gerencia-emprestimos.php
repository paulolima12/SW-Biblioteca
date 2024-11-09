<?php

session_start();
include '../conexao.php';

if ((!isset($_SESSION['id_funcionario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {
    unset($_SESSION['id_funcionario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);
    header('Location: ../index.html');
    exit();
}

$id_funcionario = $_GET['id_funcionario'];
$id_emprestimo = $_GET['id_emprestimo'];

if (!isset($_GET['id_emprestimo'])) {
    echo "<script>alert('ID do empréstimo não fornecido.'); window.location.href='index_emprestimos.php';</script>";
    exit();
}

if ($_SESSION['id_funcionario'] != $id_funcionario) {
    header('Location: index_emprestimos.php');
    exit();
}

$sql = "SELECT emprestimo.*, livro.titulo AS titulo_livro, usuario.nome AS nome_usuario, usuario.id_usuario
        FROM emprestimo
        JOIN livro ON emprestimo.id_livro = livro.id_livro
        JOIN usuario ON emprestimo.id_usuario = usuario.id_usuario
        WHERE emprestimo.id_emprestimo = $id_emprestimo";
$resultado = $conexao->query($sql);
$dados_emprestimo = $resultado->fetch_assoc();

if (!$dados_emprestimo) {
    echo "<script>alert('Empréstimo não encontrado.'); window.location.href='index_emprestimos.php';</script>";
    exit();
}

$data_devolucao = new DateTime($dados_emprestimo['data_devolucao']);
$data_atual = new DateTime();

if ($data_devolucao < $data_atual && $dados_emprestimo['status_devolucao'] != 'atrasada') {
    $atualizar_status = "UPDATE emprestimo SET status_devolucao = 'atrasada', `status` = 'em andamento' WHERE id_emprestimo = $id_emprestimo";
    $conexao->query($atualizar_status);

    $bloquear_usuario = "UPDATE usuario SET `status` = 'bloqueado' WHERE id_usuario = " . $dados_emprestimo['id_usuario'];
    $conexao->query($bloquear_usuario);

    // Recarregar os dados do empréstimo com as atualizações
    $resultado = $conexao->query($sql);
    $dados_emprestimo = $resultado->fetch_assoc();
}

include 'menu.php';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4" style="font-weight: 600;">Gerenciar empréstimo de ID: <?php echo $id_emprestimo ?> </h1>
            <ol class="breadcrumb mb-4">
                <li id="dataAtual" class="breadcrumb-item active"></li>
            </ol>
            <div class="card mb-4"
                style="padding: 15px; box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <p><strong>Livro:</strong> <?= htmlspecialchars($dados_emprestimo['titulo_livro']); ?></p>
                <p><strong>Usuário:</strong> <?= htmlspecialchars($dados_emprestimo['nome_usuario']); ?></p>
                <p><strong>Data de empréstimo:</strong>
                    <?= date("d/m/Y", strtotime($dados_emprestimo['data_emprestimo'])); ?></p>
                <p><strong>Data de devolução:</strong>
                    <?= date("d/m/Y", strtotime($dados_emprestimo['data_devolucao'])); ?></p>
                <p><strong>Status do empréstimo:</strong> <?= $dados_emprestimo['status']; ?></p>
                <p><strong>Status de devolução:</strong> <?= $dados_emprestimo['status_devolucao']; ?></p>
            </div>

            <?php

            echo "<form action='processa_gerenciamento_emprestimo.php' method='POST'>
                    <input type='hidden' name='id_emprestimo' value='" . $id_emprestimo . "'>";

            if ($dados_emprestimo['status'] == 'rejeitado') {
                echo "<h5 style='margin-top: 10px;' >O empréstimo foi rejeitado. Nenhuma ação disponível.</h5>";
            } else if ($dados_emprestimo['status'] == 'concluído') {
                echo "<h5 style='margin-top: 10px;' >O empréstimo foi concluído. Nenhuma ação disponível.</h5>";
            } else if ($dados_emprestimo['status_devolucao'] == 'pendente') {
                echo "<button style='margin-top: 10px; background-color: #ee0979; border: none; border-radius: 5px; padding: 5px;' type='submit' name='acao' value='aceitar_devolucao'>Aceitar devolução</button>
                        <button style='margin-top: 10px; background-color: #ee0979; border: none; border-radius: 5px; padding: 5px;' type='submit' name='acao' value='rejeitar_devolucao'>Rejeitar devolução</button>";
            } else if ($dados_emprestimo['status_devolucao'] == 'atrasada') {
                echo "<h5 style='margin-top: 10px;'>O empréstimo está atrasado. O usuário está bloqueado e o livro indisponível até você aceitar a devolução.</h5>
                    <button style='margin-top: 10px; background-color: #ee0979; border: none; border-radius: 5px; padding: 5px;' type='submit' name='acao' value='aceitar_devolucao_atrasada'>Aceitar devolução novamente</button>";
            } else if ($dados_emprestimo['status_devolucao'] == 'aguardando confirmação') {
                echo "<h5 style='margin-top: 10px;'>O usuário ainda não confirmou devolução. Nenhuma ação disponível.</h5>";
            } else if ($dados_emprestimo['status'] == 'rejeitado') {
                echo "<h5 style='margin-top: 10px;' >O empréstimo foi rejeitado. Nenhuma ação disponível.</h5>";
            }

            ?>
            </form>

        </div>
    </main>

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Biblioteca Online 2024</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>

<script>
    function mostrarDataAtual() {
        const agora = new Date();
        const dataFormatada = agora.toLocaleDateString('pt-BR') + ' - ' + agora.toLocaleTimeString('pt-BR');
        document.getElementById('dataAtual').textContent = "Data e hora atual: " + dataFormatada;
    }

    setInterval(mostrarDataAtual, 1000); // Atualiza a cada segundo
</script>

<script>
    function confirmDelete() {
        return confirm("Você tem certeza de que deseja deletar os dados?");
    }
    function confirmUpdate() {
        return confirm("Você tem certeza de que deseja atualizar os dados?");
    }
</script>
</body>
