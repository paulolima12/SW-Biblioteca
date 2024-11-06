<?php
session_start();

if ((!isset($_SESSION['id_funcionario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_funcionario']);
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
            <h1 class="mt-4">Controle de biblioteca</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard de funcionário</li>
            </ol>
            <button class='btn btn-outline-secondary' style="margin-bottom: 1rem;" data-bs-toggle="modal"
                data-bs-target="#bookModal">Inserir livros</button>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabela de livros
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Título</th>
                                <th scope="col">Ano de publicação</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT * FROM livro";
                            $consulta = $conexao->query($sql);
                            while ($dados = $consulta->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $dados['id_livro'] . "</td>";
                                echo "<td>" . $dados['isbn'] . "</td>";
                                echo "<td>" . $dados['titulo'] . "</td>";
                                echo "<td>" . $dados['ano_publicacao'] . "</td>";
                                echo "<td>" . $dados['status'] . "</td>";
                                // echo "<td>
                                //             <a href='#?id_livro=" . $dados["id_livro"] . "'><button class='btn btn-primary'>Atualizar</button></a>
                                //             <a href='#?id_livro=" . $dados["id_livro"] . "'><button class='btn btn-danger' onclick='return confirmDelete()'>Deletar</button></a>
                                //     </td>";
                                echo "</tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Novo Livro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookForm" method="POST" action="form_insere_livro.php">
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" required>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                            <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao"
                                required>
                        </div>
                        <!-- <div class="mb-3">
                        <label for="id_editora" class="form-label">Publisher</label>
                        <select class="form-select" id="id_editora" name="id_editora" required>
                        <option value="1">Publisher 1</option>
                        <option value="2">Publisher 2</option>
                        <option value="3">Publisher 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_genero" class="form-label">Genre</label>
                        <select class="form-select" id="id_genero" name="id_genero" required>
                        <option value="1">Fiction</option>
                        <option value="2">Non-Fiction</option>
                        <option value="3">Mystery</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                        <option value="1">Available</option>
                        <option value="0">Unavailable</option>
                        </select>
                    </div> -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Adicionar</button>
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
        return confirm("Você tem certeza de que deseja atualizar os dados?");
    }
</script>
</body>



</html>