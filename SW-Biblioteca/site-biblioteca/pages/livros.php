<?php
session_start();

if ((!isset($_SESSION['id_usuario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
}

include '../conexao.php';
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
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.2s;
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

    <section id="livros" class="py-5">
        <div class="container">
            <div class="row">
                <?php
                $sql = "SELECT livro.id_livro, livro.titulo, livro.isbn, livro.capa, autor.nome AS autor 
                    FROM livro
                    JOIN livro_autor ON livro.id_livro = livro_autor.id_livro
                    JOIN autor ON livro_autor.id_autor = autor.id_autor
                    WHERE livro.status = 'disponível'";
                $consulta = $conexao->query($sql);
                while ($dados = $consulta->fetch_assoc()) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <!-- Link ainda não está funcionando  -->
                        <a href="livro_selecionado.php?id_livro=<?= $dados['id_livro'] ?>" class="text-decoration-none"
                            style="cursor">
                            <div class="card mb-4" id="links-livro">
                                <img src="capa_livro/<?= $dados['capa'] ?>" class="card-img-top" alt="Capa do livro">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #666666"><?= $dados['titulo'] ?></h5>
                                    <p class="card-text" style="color: #666666"> <?= $dados['autor'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-3 bg-black">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Copyright &copy; Biblioteca Online 2024 - Desenvolvido por
                @eo.paulinn</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>

</html>