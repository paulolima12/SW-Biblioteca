<?php

session_start();
include '../conexao.php';

if ((!isset($_SESSION['id_usuario']) == true) && (!isset($_SESSION['nome']) == true) && (!isset($_SESSION['email'])) == true) {

    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome']);
    unset($_SESSION['email']);

    header('Location: ../index.html');
    exit();
}

$id_usuario = $_GET['id_usuario'];
$id_emprestimo = $_GET['id_emprestimo'];

if (!isset($_GET['id_emprestimo'])) {
    echo "<script>alert('ID do empréstimo não fornecido.'); window.location.href='emprestimos.php';</script>";
    exit();
}

if ($_SESSION['id_usuario'] != $id_usuario) {
    header('Location: emprestimos.php');
    exit();
}

$sql = "SELECT emprestimo.*, livro.titulo AS titulo_livro, usuario.nome AS nome_usuario, funcionario.nome AS nome_funcionario
        FROM emprestimo
        JOIN livro ON emprestimo.id_livro = livro.id_livro
        JOIN usuario ON emprestimo.id_usuario = usuario.id_usuario
        LEFT JOIN funcionario ON emprestimo.id_funcionario = funcionario.id_funcionario
        WHERE emprestimo.id_emprestimo = $id_emprestimo AND usuario.id_usuario = $id_usuario";
$resultado = $conexao->query($sql);
$dados_emprestimo = $resultado->fetch_assoc();

if (!$dados_emprestimo) {
    echo "<script>alert('Empréstimo não encontrado.'); window.location.href='emprestimos.php';</script>";
    exit();
}

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
            padding-top: 3.5%;
            height: 100%;
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
        <div class="container-fluid px-5 py-5">
            <h1 class="mt-4" style="font-weight: 600;">Gerenciar empréstimo de ID: <?php echo $id_emprestimo ?> </h1>
            <ol class="breadcrumb mb-4">
                <li id="dataAtual" class="breadcrumb-item active"></li>
            </ol>
            <div class="card mb-4"
                style="padding: 15px; line-height: 15px; box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <p><strong>Livro:</strong> <?= htmlspecialchars($dados_emprestimo['titulo_livro']); ?></p>
                <p><strong>Usuário:</strong> <?= htmlspecialchars($dados_emprestimo['nome_usuario']); ?></p>
                <p><strong>Funcionário:</strong> <?= htmlspecialchars($dados_emprestimo['nome_funcionario']); ?></p>
                <p><strong>Data de empréstimo:</strong>
                    <?= date("d/m/Y", strtotime($dados_emprestimo['data_emprestimo'])); ?></p>
                <p><strong>Data de devolução:</strong>
                    <?= date("d/m/Y", strtotime($dados_emprestimo['data_devolucao'])); ?></p>
                <p><strong>Status do empréstimo:</strong> <?= $dados_emprestimo['status']; ?></p>
                <p><strong>Status de devolução:</strong> <?= $dados_emprestimo['status_devolucao']; ?></p>
            </div>

            <?php

            echo "<form action='processa_gerenciamento_emprestimos.php' method='POST'>
                    <input type='hidden' name='id_emprestimo' value='" . $dados_emprestimo['id_emprestimo'] . "'>";

            if ($dados_emprestimo['status'] == 'solicitado') {
                echo "<h5 style='margin-top: 10px;'>Aguarde o funcionário aprovar seu empréstimo. Nenhuma ação disponível.</h5>";
            } else if ($dados_emprestimo['status'] == 'rejeitado') {
                echo "<h5 style='margin-top: 10px;'>Seu empréstimo foi rejeitado pelo funcionário. Nenhuma ação disponível.</h5>";
            } else if ($dados_emprestimo['status_devolucao'] == 'aguardando confirmação') {
                echo "<button onclick='return confirmDevolucao()' style='margin-top: 10px; background-color: #ee0979; color: white; border: none;' type='submit' name='acao' value='confirmar_devolucao'>Confirmar devolução</button>";
            } else if ($dados_emprestimo['status_devolucao'] == 'atrasada') {
                echo "<h5 style='margin-top: 10px;'>O empréstimo está atrasado. Você permanecerá bloqueado até que o funcionário confirme sua devolução.</h5>
                        <button onclick='return confirmDevolucao()' style='margin-top: 10px; background-color: #ee0979; color: white; border: none;' type='submit' name='acao' value='confirmar_devolucao'>Confirmar devolução</button>";
            } else if ($dados_emprestimo['status'] == 'concluído') {
                echo "<h5 style='margin-top: 10px;'>O empréstimo foi concluído. Nenhuma ação disponível.</h5>";
            } else if ($dados_emprestimo['status_devolucao'] == 'pendente') {
                echo "<h5 style='margin-top: 10px;'>Aguarde o funcionário confirmar sua devolução. Nenhuma ação disponível.</h5>";
            }

            ?>
            </form>

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

        setInterval(mostrarDataAtual, 1000); 
    </script>

    <script>
        function confirmDelete() {
            return confirm("Você tem certeza de que deseja deletar os dados?");
        }
        function confirmUpdate() {
            return confirm("Você tem certeza de que deseja atualizar os dados?");
        }
        function confirmDevolucao() {
            return confirm("Você tem certeza de que deseja confirmar a devolução? Essa ação não pode ser desfeita.")
        }
    </script>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>