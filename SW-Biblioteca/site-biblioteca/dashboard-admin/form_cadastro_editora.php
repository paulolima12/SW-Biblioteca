<?php

    session_start();

    if((!isset($_SESSION['id_adm']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true){
        
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
            <h1 class="mt-4" style="font-weight: 600;">Gerenciamento de editoras</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard de administrador</li>
            </ol>
            <button class='btn btn-outline-light' style="margin-bottom: 1rem; background-color: #ee0979"
                data-bs-toggle="modal" data-bs-target="#bookModal">Cadastrar editora</button>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabela de editoras
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Editora</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT editora.editora, editora.id_editora FROM editora";
                            $consulta = $conexao->query($sql);
                            while ($dados = $consulta->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $dados['id_editora'] . "</td>";
                                echo "<td>" . $dados['editora'] . "</td>";
                                echo "<td>
                                        <a href='apaga_editora.php?id_editora=" . $dados["id_editora"] . "'>
                                            <button
                                                onclick='return confirmDelete()'
                                                class='btn btn-outline-light' 
                                                style='max-width: 100px; font-size: small; 
                                                background-color: #ee0979'> Excluir </button>
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
                    <h5 class="modal-title" id="bookModalLabel">Adicionar editora</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookForm" method="POST" action="adiciona_campos.php">
                        <div class="mb-3">
                            <label style="margin-bottom: 0" for="isbn" class="form-label">Nome da editora</label>
                            <p style="font-size: smaller; color: #666666">Não se esqueça de verificar se a editora já está cadastrada.</p>
                            <input type="text" class="form-control" id="editora" name="editora"  maxlength="100" minlength="3" placeholder="ex.: Editora teste." required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-outline-light"
                                style="background-color: #ee0979">Adicionar</button>
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