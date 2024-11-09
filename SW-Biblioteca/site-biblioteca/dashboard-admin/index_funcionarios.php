<?php
session_start();

if ((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_adm']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';
include 'menu.php';

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4" style="font-weight: 600;">Gerenciamento de funcionários</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard de administrador</li>
            </ol>
            <button class='btn btn-outline-light' style="margin-bottom: 1rem; background-color: #ee0979"
                data-bs-toggle="modal" data-bs-target="#bookModal">Cadastrar funcionários</button>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabela de funcionários
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT * FROM funcionario";
                            $consulta = $conexao->query($sql);
                            while ($dados = $consulta->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $dados['id_funcionario'] . "</td>";
                                echo "<td>" . $dados['cpf'] . "</td>";
                                echo "<td>" . $dados['nome'] . "</td>";
                                echo "<td>" . $dados['email'] . "</td>";
                                echo "<td>" . $dados['status'] . "</td>";
                                echo "<td>
                                        <a href='ativa-desativa.php?id_funcionario=" . $dados["id_funcionario"] . "'>
                                            <button  
                                                class='btn btn-outline-light'
                                                onclick='return confirmUpdate()' 
                                                style='font-size: small; 
                                                background-color: #ee0979'> Ativar / Inativar </button>
                                        </a>
                                    </td>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal - Inserir livros -->
    <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Cadastrar funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookForm" method="POST" action="inserir_funcionarios.php">
                        <div class="mb-3">
                            <label for="isbn" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" minlength="11" maxlength="11" required>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="titulo" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="ano_publicacao" class="form-label">Email</label>
                            <input type="email" class="form-control" id="ano_publicacao" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="ano_publicacao" class="form-label">Senha</label>
                            <input type="text" class="form-control" id="ano_publicacao" name="senha" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-outline-light"
                                style="background-color: #ee0979">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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