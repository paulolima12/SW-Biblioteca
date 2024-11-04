<?php
    session_start();

    if((!isset($_SESSION['id_usuario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true){
        
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
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="../css/styles.css" rel="stylesheet" />

    <style>
        body {
            color: #666; /* Um tom suave de cinza */
        }
    </style>
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="#">Biblioteca Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- Content section 1 -->
    <section id="scroll">
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="p-5">
                        <img class="img-fluid rounded-circle" src="../img/livro.jpg" alt="Imagem de livros e leitura" />
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="p-5">
                        <h2 class="display-4">Descubra novos mundos</h2>
                        <p>Explore uma vasta coleção de livros, artigos e revistas. Nossa biblioteca oferece acesso a conteúdos de diferentes áreas do conhecimento, prontos para serem descobertos!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content section 2 -->
    <section>
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6">
                    <div class="p-5">
                        <img class="img-fluid rounded-circle" src="../img/biblioteca leonardo.jpg" alt="Imagem de uma biblioteca clássica" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <h2 class="display-4">Acesso ilimitado</h2>
                        <p>Com nossa plataforma, você pode controlar seus empréstimos de livros a qualquer hora e de qualquer lugar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content section 3 -->
    <section>
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="p-5">
                        <img class="img-fluid rounded-circle" src="../img/SHOW.jfif" alt="Imagem representando eventos com autores" />
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="p-5">
                        <h2 class="display-4">Conecte-se com autores</h2>
                        <p>Participe de discussões, eventos e webinars com autores e especialistas. Aumente sua interação!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-3 bg-black">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Copyright &copy; Biblioteca Online 2024 - Desenvolvido por @eo.paulinn</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>
</html>
