<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header('Location: pages/livros.php');
    exit();
} elseif (isset($_SESSION['id_funcionario'])) {
    header('Location: dashboard-func/index.php');
    exit();
} elseif (isset($_SESSION['id_adm'])) {
    header('Location: dashboard-admin/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Login da Biblioteca Online" />
    <meta name="author" content="Biblioteca Online" />
    <title>Login - Biblioteca Online</title>
    <link rel="icon" type="image/png" href="img/FAVICON.png" />


    <!-- Font Awesome icons (free version) -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
        rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        #contact {
            background-image: url('img/biblioteca_leonardo.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            padding-top: 7%;
        }

        #contact .container-sm {
            background-color: rgba(255, 255, 255, 0.86);
            border-radius: 15px;
            padding: 2em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
        }

        #contact h2 {
            color: #333;
            font-weight: 700;
        }

        #contact p.lead {
            color: #666;
        }

        #contact input[type="email"],
        #contact input[type="password"] {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 0.75em;
            font-size: 1em;
        }

        #contact input[type="submit"] {
            background-color: #ff4081;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.75em;
            font-weight: bold;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1em;
        }

        #contact input[type="submit"]:hover {
            background-color: #e03370;
        }
        
    </style>
</head>

<body id="page-top" style="height: 100vh;">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5" style="z-index: 10; position: relative">
            <a class="navbar-brand" href="index.html">Biblioteca Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro.html">Cadastre-se</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section id="contact" style="display: flex; align-items: center; justify-content: center; height: 100%;">
        <div class="container-sm col-lg-5" style="border: 1px solid black; border-radius: 1em; padding-top: 2em;">
            <div class="row text-center">
                <h2>Login</h2>
                <p class="lead">Preencha os dados</p>
            </div>
            <div class="row justify-content-center my-5">
                <div class="col-lg-6">
                    <form action="processa_login.php" method="POST">
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailInput" placeholder="email@exemplo.com"
                                name="email_login" required>
                        </div>
                        <div class="mb-3">
                            <label for="senhaInput" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senhaInput" placeholder="********"
                                name="senha_login" required>
                        </div>

                        <input type="submit" value="Entrar" class="btn btn-primary" style="width: 100%;">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-3 bg-black">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Copyright &copy; Biblioteca Online 2024</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validation Script -->
    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            const email = document.getElementById('emailInput').value;
            const senha = document.getElementById('senhaInput').value;

            if (!email || !senha) {
                alert('Preencha todos os campos');
                event.preventDefault();
            }
        });

    </script>
</body>

</html>