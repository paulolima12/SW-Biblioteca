<?php
session_start();

if ((!isset($_SESSION['id_funcionario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_funcionario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
    exit();
}

include '../conexao.php';
include 'menu.php';

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4" style="font-weight: 600;">Gerenciamento de empréstimos</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard de funcionário</li>
            </ol>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">NOTA: Ao aprovar um empréstimo, APENAS você será responsável por ele e mais
                    ninguém poderá gerenciá-lo.</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabela de empréstimos
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Data - Início</th>
                                <th scope="col">Data - Devolução</th>
                                <th scope="col">Status</th>
                                <th scope="col">Status - Devolução</th>
                                <th scope="col">Livro</th>
                                <th scope="col">Usuário</th>
                                <th scope="col">Funcionário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT emprestimo.id_emprestimo, emprestimo.data_devolucao, emprestimo.data_emprestimo, 
                                        emprestimo.status, emprestimo.status_devolucao, emprestimo.id_livro, emprestimo.id_usuario, 
                                        emprestimo.id_funcionario, livro.titulo as livro, funcionario.nome as funcionario, 
                                        usuario.nome as usuario 
                                    FROM emprestimo
                                    LEFT JOIN livro ON emprestimo.id_livro = livro.id_livro
                                    LEFT JOIN funcionario ON emprestimo.id_funcionario = funcionario.id_funcionario
                                    LEFT JOIN usuario ON emprestimo.id_usuario = usuario.id_usuario";

                            $consulta = $conexao->query($sql);
                            while ($dados = $consulta->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $dados['id_emprestimo'] . "</td>";
                                echo "<td>" . date("d/m/Y", strtotime($dados['data_emprestimo'])) . "</td>";
                                echo "<td>" . date("d/m/Y", strtotime($dados['data_devolucao'])) . "</td>";
                                echo "<td>" . $dados['status'] . "</td>";
                                echo "<td>" . $dados['status_devolucao'] . "</td>";
                                echo "<td>" . $dados['livro'] . "</td>";
                                echo "<td>" . $dados['usuario'] . "</td>";
                                echo "<td>" . (!empty($dados['funcionario']) ? $dados['funcionario'] : 'N/A') . "</td>";

                                if ($dados['status'] == 'solicitado') {
                                    echo "<td>
                                            <a href='aprova-rejeita_emprestimo.php?id_emprestimo=" . $dados["id_emprestimo"] . "&acao=aprova&id_livro=" . $dados["id_livro"] . "'>
                                                <button
                                                    class='btn btn-outline-light'
                                                    onclick='return confirmUpdate()' 
                                                    style='font-size: small;                                                 
                                                    background-color: #ee0979'> Aprovar </button>
                                            </a>
                                            <a href='aprova-rejeita_emprestimo.php?id_emprestimo=" . $dados["id_emprestimo"] . "&acao=rejeita&id_livro=" . $dados["id_livro"] . "'>
                                                <button  
                                                    class='btn btn-outline-light'
                                                    onclick='return confirmUpdate()' 
                                                    style='font-size: small;                                                 
                                                    background-color: #ee0979'> Rejeitar </button>
                                            </a>
                                        </td>";
                                } else if ($dados['id_funcionario'] == $_SESSION['id_funcionario']) {
                                    echo "<td>
                                            <a href='gerencia-emprestimos.php?id_emprestimo=" . $dados["id_emprestimo"] . "&id_funcionario=" . $_SESSION['id_funcionario'] . "'>
                                                <button
                                                    class='btn btn-outline-light'                                                    
                                                    style='font-size: small;                                                 
                                                    background-color: #ee0979'> Gerenciar </button>
                                            </a>
                                        </td>";
                                } else {
                                    echo "<td>-</td>";
                                }

                                echo "</tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
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
    function confirmDelete() {
        return confirm("Você tem certeza de que deseja deletar os dados?");
    }
    function confirmUpdate() {
        return confirm("Você tem certeza de que deseja atualizar os dados?");
    }
</script>
</body>



</html>