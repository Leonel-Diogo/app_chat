<?php
session_start();
if (!isset($_SESSION['username'])) {

    ?>


    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Chat-SignUp</title>
        <!--BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--CSS-->
        <link rel="stylesheet" href="assets/css/geral.css">
        <!--ICON DO APP-->
        <link rel="icon" href="assets/image/chat.png">
    </head>

    <body class="d-flex justify-content-center align-items-center vh-100">
        <div class="w-400 p-3 shadow rounded">
            <form action="app/http/signup.php" enctype="multipart/form-data" method="post">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <img src="assets/image/chat.png" class="w-25" alt="">
                    <h3 class="display-5 fs-1 text-center">Criar conta</h3><!---->
                </div>

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php }
                if (isset($_GET['name'])) {
                    $name = $_GET['name'];
                } else
                    $name = '';
                if (isset($_GET['username'])) {
                    $username = $_GET['username'];
                } else
                    $username = '';
                if (isset($_GET['password'])) {
                    $password = $_GET['password'];
                } else
                    $password = '';
                ?>

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" value="<?= $name ?>" class="form-control" placeholder="Nome Sobrenome">
                </div>
                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="email" name="username" value="<?= $username ?>" class="form-control"
                        placeholder="nome@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password" value="<?= $password ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto de perfil</label>
                    <input type="file" name="pfile" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Criar conta" class="btn btn-primary">
                    <a href="index.php">Entrar</a>
                </div>
            </form>

        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>

    </html>
    <?php
} else {
    # code...
    header("location: home.php");
    exit;
} ?>