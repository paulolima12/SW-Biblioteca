<?php
session_start();

if ((!isset($_SESSION['id_usuario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);
    header('Location: ../index.html');
}

include '../conexao.php';
$id_livro = $_GET['id_livro'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Biblioteca Online - Seu Acesso ao Conhecimento" />
    <meta name="author" content="Biblioteca Online" />
    <title>Biblioteca Online</title>
    <link rel="icon" type="image/x-icon" href="../img/FAVICON.png" />

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
        rel="stylesheet" />

    <!-- Core theme CSS -->
    <link href="../css/styles.css" rel="stylesheet" />

    <style>
        html {
            height: 100%;
            margin: 0;
        }

        body {
            color: #666;
            padding-top: 10%;
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
        }

        #info-livro .container {
            margin-top: 30px;
        }

        #info-livro {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        #capa-livro {
            width: 250px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        #emprestimo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        h2,
        h3 {
            color: #333;
        }

        .btn-primary {
            background-color: #ee0979;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #c12470;
        }

        /* Nao ta funcionando */
        #button-emprestimo {
            width: 100% !important;
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="../index.html">Biblioteca Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="livros.php">Livros</a></li>
                    <li class="nav-item"><a class="nav-link" href="emprestimos.php">Empréstimos</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6" id="info-livro">
                <?php
                $sql = "SELECT livro.titulo, livro.isbn, livro.ano_publicacao, livro.capa, 
                        genero.genero AS genero, editora.editora AS editora, autor.nome AS autor
                        FROM livro
                        LEFT JOIN genero ON livro.id_genero = genero.id_genero
                        LEFT JOIN editora ON livro.id_editora = editora.id_editora
                        JOIN livro_autor ON livro.id_livro = livro_autor.id_livro
                        JOIN autor ON livro_autor.id_autor = autor.id_autor
                        WHERE livro.id_livro = $id_livro";
                $consulta = $conexao->query($sql);
                $dados = $consulta->fetch_assoc();
                ?>

                <img id="capa-livro" src="capa_livro/<?= $dados['capa'] ?>" alt="Capa do Livro" class="img-fluid">
                <div>
                    <h2 style="margin-bottom: 50px; margin-top: 50px;"><?= $dados['titulo'] ?></h2>
                    <div style="line-height: 20px;">
                        <p><strong>ISBN:</strong> <?= $dados['isbn'] ?></p>
                        <p><strong>Ano de Publicação:</strong> <?= $dados['ano_publicacao'] ?></p>
                        <p><strong>Gênero:</strong> <?= $dados['genero'] ?></p>
                        <p><strong>Editora:</strong> <?= $dados['editora'] ?></p>
                        <p><strong>Autor:</strong> <?= $dados['autor'] ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6" id="emprestimo">
                <h3>Solicitação de empréstimo</h3>
                <form action="processa_emprestimo.php" method="post">
                    <input type="hidden" name="id_livro" value="<?= $id_livro ?>">

                    <label for="data_emprestimo">Data de empréstimo:</label>
                    <input style="margin-bottom: 20px;" type="date" name="data_emprestimo" required class="form-control"
                        value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">

                    <label for="data_devolucao">Data de devolução:</label>
                    <input style="margin-bottom: 20px;" type="date" name="data_devolucao" required class="form-control"
                        min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                        max="<?= date('Y-m-d', strtotime('+6 day')) ?>">

                    <button style="width: 100%;" type="submit" class="btn btn-primary mt-3" id="button-emprestimo">
                        Solicitar empréstimo
                    </button>
                </form>
            </div>

        </div>
    </div>

    <footer class="footer py-3 bg-black">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Copyright &copy; Biblioteca Online 2024</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>