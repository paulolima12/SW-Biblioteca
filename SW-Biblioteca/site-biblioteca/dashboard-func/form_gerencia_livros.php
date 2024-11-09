<?php
session_start();

if ((!isset($_SESSION['id_funcionario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_funcionario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$id_livro = $_GET['id_livro'];

include 'menu.php';

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4" style="font-weight: 600;">Atualizar / Deletar livro</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Painel de livros</a></li>
                <li class="breadcrumb-item active">Gerenciar livro</li>
            </ol>
            <form action="atualiza_livros.php?id_livro=<?php echo $id_livro; ?>" method="POST">

                <?php
                $sql = "SELECT livro.id_livro, livro.isbn, livro.titulo, livro.ano_publicacao, livro.status, livro.capa,
                        livro.id_editora, livro.id_genero
                        FROM livro
                        WHERE livro.id_livro = $id_livro";

                $consulta = $conexao->query($sql);
                $dados = $consulta->fetch_assoc();
                ?>

                <input type="hidden" name="id_livro" value="<?php echo $dados['id_livro']; ?>">
                <input type="hidden" name="isbn_atual" value="<?php echo $dados['isbn']; ?>">

                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" name="isbn" maxlength="14" minlength="14"
                        value="<?php echo $dados['isbn']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" value="<?php echo $dados['titulo']; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="ano_publicacao" class="form-label">Ano de publicação</label>
                    <input type="number" class="form-control" name="ano_publicacao" maxlength="4" minlength="4"
                        value="<?php echo $dados['ano_publicacao']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="capa" class="form-label">Arquivo da capa do livro</label>
                    <input type="text" class="form-control" name="capa" value="<?php echo $dados['capa']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="id_editora" class="form-label">Editora</label>
                    <select class="form-select" id="id_editora" name="id_editora" required>
                        <?php
                        $sql_editora = "SELECT id_editora, editora FROM editora";
                        $resultado_editora = $conexao->query($sql_editora);
                        while ($editora = $resultado_editora->fetch_assoc()) {
                            $selected = ($dados['id_editora'] == $editora['id_editora']) ? 'selected' : '';
                            echo "<option value='" . $editora['id_editora'] . "' $selected>" . $editora['editora'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_genero" class="form-label">Gênero</label>
                    <select class="form-select" id="id_genero" name="id_genero" required>
                        <?php
                        $sql_genero = "SELECT id_genero, genero FROM genero";
                        $resultado_genero = $conexao->query($sql_genero);
                        while ($genero = $resultado_genero->fetch_assoc()) {
                            $selected = ($dados['id_genero'] == $genero['id_genero']) ? 'selected' : '';
                            echo "<option value='" . $genero['id_genero'] . "' $selected>" . $genero['genero'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_autor" class="form-label">Autor</label>
                    <select class="form-select" id="id_autor" name="id_autor" required>
                        <?php
                        $sql_autor = "SELECT id_autor, nome FROM autor";
                        $resultado_autores = $conexao->query($sql_autor);

                        $sql_livro_autor = "SELECT id_autor FROM livro_autor WHERE id_livro = " . $dados['id_livro'];
                        $resultado_livro_autor = $conexao->query($sql_livro_autor);
                        $autor_livro = $resultado_livro_autor->fetch_assoc();
                        $id_autor_livro = $autor_livro['id_autor'];

                        while ($autor = $resultado_autores->fetch_assoc()) {
                            $selected = ($id_autor_livro == $autor['id_autor']) ? 'selected' : '';
                            echo "<option value='" . $autor['id_autor'] . "' $selected>" . $autor['nome'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirmUpdate()">Atualizar</button>
                <br>
                <button style="margin-top: 1em;" type="reset" class="btn btn-secondary btn-sm">Resetar
                    alterações</button>
            </form>
            <a <?php echo "href='apaga_livros.php?id_livro=" . $id_livro . "';" ?>><button style="margin-top: 1em;"
                    class="btn btn-danger btn-sm" name="delete" value="1" onclick="return confirmDelete()">Excluir
                    livro</button></a>
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
<script src="assets/demo/chart-pie-demo.js"></script>

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