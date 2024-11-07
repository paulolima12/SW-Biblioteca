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
            <h1 class="mt-4" style="font-weight: 600;">Gerenciamento de livros</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard de administrador</li>
            </ol>
            <button class='btn btn-outline-light' style="margin-bottom: 1rem; background-color: #ee0979"
                data-bs-toggle="modal" data-bs-target="#bookModal">Inserir livros</button>
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
                                <th scope="col">Editora</th>
                                <th scope="col">Gênero</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT livro.id_livro, livro.isbn, livro.titulo, livro.ano_publicacao, livro.status,
                                    genero.genero AS genero, editora.editora AS editora, autor.nome AS autor
                                    FROM livro
                                    LEFT JOIN genero ON livro.id_genero = genero.id_genero
                                    LEFT JOIN editora ON livro.id_editora = editora.id_editora
                                    LEFT JOIN livro_autor ON livro.id_livro = livro_autor.id_livro
                                    LEFT JOIN autor ON livro_autor.id_autor = autor.id_autor";
                            $consulta = $conexao->query($sql);
                            while ($dados = $consulta->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $dados['id_livro'] . "</td>";
                                echo "<td>" . $dados['isbn'] . "</td>";
                                echo "<td>" . $dados['titulo'] . "</td>";
                                echo "<td>" . $dados['genero'] . "</td>";
                                echo "<td>" . $dados['editora'] . "</td>";
                                echo "<td>" . $dados['autor'] . "</td>";
                                echo "<td>" . $dados['status'] . "</td>";
                                echo "<td>
                                        <a href='form_gerencia_livros.php?id_livro=" . $dados["id_livro"] . "'>
                                            <button  
                                                class='btn btn-outline-light' 
                                                style='max-width: 100px; font-size: small; 
                                                background-color: #ee0979'> Gerenciar </button>
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
                    <h5 class="modal-title" id="bookModalLabel">Adicionar livro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookForm" method="POST" action="inserir_livros.php">
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" name="isbn_atual" min="14" max="14" required>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="ano_publicacao" class="form-label">Ano de publicação</label>
                            <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao"
                                min="1000" max="2024" minlength="4" maxlength="4" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_editora" class="form-label">Editora</label>
                            <select class="form-select" id="id_editora" name="id_editora" required>
                                <?php
                                // Busca as editoras no banco
                                $sql_editora = "SELECT id_editora, editora FROM editora";
                                $resultado_editora = $conexao->query($sql_editora);
                                while ($editora = $resultado_editora->fetch_assoc()) {
                                    echo "<option value='" . $editora['id_editora'] . "'>" . $editora['editora'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_genero" class="form-label">Gênero</label>
                            <select class="form-select" id="id_genero" name="id_genero" required>
                                <?php
                                // Busca os gêneros no banco
                                $sql_genero = "SELECT id_genero, genero FROM genero";
                                $resultado_genero = $conexao->query($sql_genero);
                                while ($genero = $resultado_genero->fetch_assoc()) {
                                    echo "<option value='" . $genero['id_genero'] . "'>" . $genero['genero'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_autores" class="form-label">Autor</label>
                            <select class="form-select" id="id_autores" name="id_autores" required>
                                <?php
                                // Busca os autores no banco
                                $sql_autores = "SELECT id_autor, nome FROM autor";
                                $resultado_autores = $conexao->query($sql_autores);
                                while ($autor = $resultado_autores->fetch_assoc()) {
                                    echo "<option value='" . $autor['id_autor'] . "'>" . $autor['nome'] . "</option>";
                                }
                                ?>
                            </select>
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