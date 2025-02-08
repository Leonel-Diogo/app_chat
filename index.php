<?php
session_start();
if (!isset($_SESSION['username'])) {

    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Chat</title>
        <!--BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--CSS-->
        <link rel="stylesheet" href="assets/css/geral.css?v=<?= time() ?>">
        <!--ICON DO APP-->
        <link rel="icon" href="assets/image/chat.png">
    </head>

    <body class="d-flex justify-content-center align-items-center vh-100">
        <div class="w-400 p-3 shadow rounded">
            <form action="app/http/auth.php" method="post"><!--home.php/app/http/auth.php-->
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <img src="assets/image/chat.png" class="w-25" alt="">
                    <h3 class="display-5 fs-1 text-center">Entrar</h3><!---->
                </div>
                <!--FEEDBACK DE SUCESSO PARA O USUÁRIO AO LOGAR-->
                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php } ?>
                <!--FEEDBACK DE ERRO PARA O USUÁRIO AO LOGAR-->
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="username" class="form-control" placeholder="nome@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Entrar" class="btn btn-primary">
                    <a href="signup.php">Criar Conta</a>
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