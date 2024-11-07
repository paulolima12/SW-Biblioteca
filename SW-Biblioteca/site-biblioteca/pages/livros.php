<?php
session_start();

if ((!isset($_SESSION['id_usuario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';

$pesquisa_titulo = isset($_POST['pesquisa_titulo']) ? $_POST['pesquisa_titulo'] : '';
$pesquisa_autor = isset($_POST['pesquisa_autor']) ? $_POST['pesquisa_autor'] : '';
$pesquisa_genero = isset($_POST['pesquisa_genero']) ? $_POST['pesquisa_genero'] : '';
$pesquisa_editora = isset($_POST['pesquisa_editora']) ? $_POST['pesquisa_editora'] : '';

// Consultas das opções de genero, autor e editora para os filtros
$consulta_genero = "SELECT id_genero, genero FROM genero";
$consulta_editora = "SELECT id_editora, editora FROM editora";
$consulta_autor = "SELECT id_autor, nome FROM autor";

// Consultar livros com os filtros aplicados
$sql = "SELECT livro.id_livro, livro.titulo, livro.isbn, livro.capa, autor.nome AS autor 
        FROM livro
        JOIN livro_autor ON livro.id_livro = livro_autor.id_livro
        JOIN autor ON livro_autor.id_autor = autor.id_autor
        LEFT JOIN genero ON livro.id_genero = genero.id_genero
        LEFT JOIN editora ON livro.id_editora = editora.id_editora
        WHERE livro.status = 'disponível'";

// Adição de texto a consulta que será feita 
// LIKE é um operador que busca padrões de texto em SQL
if ($pesquisa_titulo) {
    $sql .= " AND livro.titulo LIKE '%$pesquisa_titulo%'";
}
if ($pesquisa_autor) {
    $sql .= " AND autor.nome LIKE '%$pesquisa_autor%'";
}
if ($pesquisa_genero) {
    $sql .= " AND genero.id_genero = '$pesquisa_genero'";
}
if ($pesquisa_editora) {
    $sql .= " AND editora.id_editora = '$pesquisa_editora'";
}

$consulta = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Biblioteca Online - Seu Acesso ao Conhecimento" />
    <meta name="author" content="Biblioteca Online" />
    <title>Biblioteca Online</title>
    <link rel="icon" type="image/x-icon" href="img/FAVICON.png" />

    <!-- Font Awesome icons (free version) -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
        rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="../css/styles.css" rel="stylesheet" />

    <style>
        body {
            color: #666;
            padding-top: 6.5%;
            min-height: 100%;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.2s;
            height: 310px;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
            flex-grow: 1;
            overflow: hidden;
        }

        #livros .card img {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: contain;
        }

        #capa-livro {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-body .card-title,
        .card-body .card-text {
            color: #666666 !important;
        }

        .card-title {
            font-size: large;
        }

        .card-text {
            font-size: smaller;
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="#">Biblioteca Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="livros.php">Livros</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Empréstimos</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="filtro-livros" class="py-4 container">
        <div class="container">
            <form method="GET" action="livros.php">
                <div class="row">
                    <!-- pesquisa por título -->
                    <div class="col-md-4">
                        <input type="text" name="titulo" class="form-control" placeholder="Pesquise por título"
                            value="<?= isset($_GET['titulo']) ? $_GET['titulo'] : '' ?>">
                    </div>

                    <!-- filtrar genero -->
                    <div class="col-md-2">
                        <select name="genero" class="form-control">
                            <option value="">Gênero</option>
                            <?php
                            // Pegar os gêneros do banco
                            $generos = $conexao->query("SELECT * FROM genero");
                            while ($genero = $generos->fetch_assoc()) {
                                echo '<option value="' . $genero['id_genero'] . '" ' . (isset($_GET['genero']) && $_GET['genero'] == $genero['id_genero'] ? 'selected' : '') . '>' . $genero['genero'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- filtrar editora -->
                    <div class="col-md-2">
                        <select name="editora" class="form-control">
                            <option value="">Editora</option>
                            <?php
                            // Pegar as editoras do banco
                            $editoras = $conexao->query("SELECT * FROM editora");
                            while ($editora = $editoras->fetch_assoc()) {
                                echo '<option value="' . $editora['id_editora'] . '" ' . (isset($_GET['editora']) && $_GET['editora'] == $editora['id_editora'] ? 'selected' : '') . '>' . $editora['editora'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- filtrar autor -->
                    <div class="col-md-2">
                        <select name="autor" class="form-control">
                            <option value="">Autor</option>
                            <?php
                            // Pegar os autores do banco
                            $autores = $conexao->query("SELECT * FROM autor");
                            while ($autor = $autores->fetch_assoc()) {
                                echo '<option value="' . $autor['id_autor'] . '" ' . (isset($_GET['autor']) && $_GET['autor'] == $autor['id_autor'] ? 'selected' : '') . '>' . $autor['nome'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section id="livros">
        <div class="container">
            <div class="row">
                <?php
                // Consulta que engloba todos os dados utilizados na exibição de livro
                $sql = "SELECT livro.id_livro, livro.titulo, livro.isbn, livro.capa, autor.nome AS autor, genero.genero AS genero, editora.editora AS editora
                        FROM livro
                        JOIN livro_autor ON livro.id_livro = livro_autor.id_livro
                        JOIN autor ON livro_autor.id_autor = autor.id_autor
                        JOIN genero ON livro.id_genero = genero.id_genero
                        JOIN editora ON livro.id_editora = editora.id_editora
                        WHERE livro.status = 'disponível'";

                // Adicão de filtros - se o campo não estiver vazio será adicionado a consulta final -> gerando filtragem
                if (isset($_GET['titulo']) && $_GET['titulo'] != '') {
                    $titulo = $_GET['titulo'];
                    $sql .= " AND livro.titulo LIKE '%$titulo%'";
                }

                if (isset($_GET['genero']) && $_GET['genero'] != '') {
                    $genero = $_GET['genero'];
                    $sql .= " AND livro.id_genero = '$genero'";
                }

                if (isset($_GET['editora']) && $_GET['editora'] != '') {
                    $editora = $_GET['editora'];
                    $sql .= " AND livro.id_editora = '$editora'";
                }

                if (isset($_GET['autor']) && $_GET['autor'] != '') {
                    $autor = $_GET['autor'];
                    $sql .= " AND livro_autor.id_autor = '$autor'";
                }

                // Execução da consulta
                $consulta = $conexao->query($sql);
                ?>

                <section id="livros" class="py-5">
                    <div class="container">
                        <div class="row">
                            <?php while ($dados = $consulta->fetch_assoc()) { ?>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <a href="livro_selecionado.php?id_livro=<?= $dados['id_livro'] ?>"
                                        class="text-decoration-none">
                                        <div class="card mb-4" id="links-livro">
                                            <img id="capa-livro" src="capa_livro/<?= $dados['capa'] ?>" class="card-img-top"
                                                alt="Capa do livro">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $dados['titulo'] ?></h5>
                                                <p class="card-text"><?= $dados['autor'] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>

                <footer class="footer py-3 bg-black">
                    <div class="container px-5">
                        <p class="m-0 text-center text-white small">Copyright &copy; Biblioteca Online 2024 </p>
                    </div>
                </footer>

                <!-- Bootstrap core JS -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
                <!-- Core theme JS -->
                <script src="js/scripts.js"></script>
</body>

</html>