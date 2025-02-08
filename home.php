<?php
session_start();

if (isset($_SESSION['username'])) {
    #DATABASE CONECTION FILE
    include_once 'app/db-connect.php';
    include_once 'app/helpers/user.php';
    include_once 'app/helpers/conversation.php';
    include_once 'app/helpers/timeAgo.php';
    #GETTING USER DATA
    $user = getUser($_SESSION['username'], $conn);

    #GETTING USER CONVERSATIONS
    $conversations = getConversation($user['id_user'], $conn);
    /*echo "<pre>";
    print_r($conversations);
    echo "</pre>"; */

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App Chat-Home</title>
        <!--BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--CSS-->
        <link rel="stylesheet" href="assets/css/geral.css?v=<?= time() ?>">
        <!--ICON DO APP-->
        <link rel="icon" href="assets/image/chat.png">
        <!--FONTAWESOME-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!--JQUERY-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>

    <body class="d-flex justify-content-center align-items-center vh-100">

        <div class="p-2 w-400 rounded shadow">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light">
                    <div class="d-flex align-items-center">

                        <img src="uploads/<?= $user['p_file'] ?>" alt="" class="w-25 rounded-circle">
                        <h3 class="fs-xs m-2"><?= $user['name'] ?></h3>

                    </div>
                    <a href="logout.php" class="btn btn-dark">Sair</a>
                </div>

                <div class="input-group mb-3">
                    <input type="text" placeholder="Pesquisar..." class="form-control">
                    <button class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <ul class="list-group mvh-50 overflow-auto">
                    <?php if (!empty($conversations)) { ?>
                        <?php foreach ($conversations as $conversation) { ?>
                            <li class="list-group-item">
                                <a href="assets/image/chat.png?user=<?= $conversation['username'] ?>"
                                    class="d-flex justify-content-center align-items-center p-2">
                                    <div class="d-flex align-items-between">
                                        <img src="uploads/<?= $conversation['p_file'] ?>" alt="" class="w-10 rounded-circle">
                                        <h3 class="fs-xs m-2">
                                            <?= $conversation['name'] ?>
                                        </h3>
                                    </div>
                                    <!-- ESTADO DOS USER -->
                                    <div title="Online">
                                        <div class="online"></div>
                                        <span class="status-text"></span>
                                    </div>

                                </a>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fa fa-comments d-block fs-big"></i>
                            Sem mensagens, comece uma conversa...
                        </div>
                    <?php } ?>


                </ul>
            </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(() => {
                /*AUTO UPDATE LAST SEEN FOR LOGGED IN USER */
                let lastSeenUpdate = () => {
                    $.get("app/ajax/update_last_seen.php");
                };
                lastSeenUpdate();
                // Atualiza a cada 10 segundos
                setInterval(lastSeenUpdate, 10000);
            });

        </script>

    </body>

    </html>
    <?php
} else {
    header("location: index.php");
    exit;
} ?>