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
    <link rel="icon" type="image/x-icon" href="../img/FAVICON.png" />

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
            padding-top: 4.5%;
            min-height: 100%;
            max-height: auto;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        html {
            height: 100%;
            margin: 0;
        }

        footer {
            margin-top: auto;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            transition: transform 0.2s;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 20px;
            width: 100%;
            height: 80px;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .card-title {
            font-weight: bold;
        }

        .card-text {
            margin: 0 10px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-gerenciar {
            background-color: #ee0979;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            align-self: center;
        }

        .btn-gerenciar:hover {
            background-color: #c12470;
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

    <section id="livros">
        <div class="container py-5 px-4" id="container-livros" style="min-height: 100%;">
            <h2>Seus empréstimos</h2>
            <ol class="breadcrumb mb-4">
                <li id="dataAtual" style="margin-bottom: 2.5%" class="breadcrumb-item active"></li>
            </ol>
            <div class="row">
                <?php
                $sql = "SELECT emprestimo.id_emprestimo, emprestimo.data_devolucao, emprestimo.data_emprestimo, 
                            emprestimo.status, emprestimo.status_devolucao, emprestimo.id_livro, emprestimo.id_usuario, 
                            emprestimo.id_funcionario, livro.titulo as livro, funcionario.nome as funcionario, 
                            usuario.nome as usuario 
                        FROM emprestimo
                        LEFT JOIN livro ON emprestimo.id_livro = livro.id_livro
                        LEFT JOIN funcionario ON emprestimo.id_funcionario = funcionario.id_funcionario
                        LEFT JOIN usuario ON emprestimo.id_usuario = usuario.id_usuario
                        WHERE emprestimo.id_usuario = {$_SESSION['id_usuario']}";

                $consulta = $conexao->query($sql);
                ?>

                <?php while ($dados = $consulta->fetch_assoc()) { ?>
                    <div class="col-md-4 mb-4 text-decoration-none" style="width: 100%;">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h5 class="card-title" style="min-width: 250px;"> <?= $dados['livro'] ?></h5>
                                </div>
                                <div>
                                    <p class="card-text" style="min-width: 200px;"><strong>Data de devolução:</strong>
                                        <?= date("d/m/Y", strtotime($dados['data_devolucao'])) ?></p>
                                </div>
                                <div>
                                    <p class="card-text"><strong>Status:</strong>
                                        <?= $dados['status'] ?></p>
                                </div>
                                <div>
                                    <a
                                        href="gerencia_emprestimo.php?id_emprestimo=<?php echo $dados['id_emprestimo']; ?>&id_usuario=<?php echo $dados['id_usuario']; ?>">
                                        <button class="btn-gerenciar">Gerenciar</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
        </div>
    </section>

    <footer class="footer py-3 bg-black">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Copyright &copy; Biblioteca Online 2024 </p>
        </div>
    </footer>

    <script>
        function mostrarDataAtual() {
            const agora = new Date();
            const dataFormatada = agora.toLocaleDateString('pt-BR') + ' - ' + agora.toLocaleTimeString('pt-BR');
            document.getElementById('dataAtual').textContent = "Data e hora atual: " + dataFormatada;
        }

        setInterval(mostrarDataAtual, 1000); // Atualiza a cada segundo
    </script>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>