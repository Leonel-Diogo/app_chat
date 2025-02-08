<?php
#ABRINDO SESSÃO
session_start();

#VERIFICANDO ERROS DE EXECUSSÃO
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# VERIFICA SE O NOME DE USUÁRIO, SENHA FORAM ENVIADOS
if (
    isset($_POST['username']) &&
    isset($_POST['password'])
) {
    # ARQUIVO DE CONEXÃO COM O BANCO DE DADOS
    include_once "../db-connect.php";

    # OBTÉM DADOS DO REQUEST POST E ARMAZENA-OS EM VARIÁVEIS
    $password = $_POST['password'];
    $username = $_POST['username'];

    #SIMPLES VALIDAÇÃO
    if (empty($username)) {
        #MENSAGEM DE ERRO
        $em = "O email é um campo obrigatório";
        #REDIRECIONA PARA index.php E EMITE MENSAGEM DE ERRO
        header("location: ../../index.php?error=$em");
    } elseif (empty($password)) {
        #MENSAGEM DE ERRO
        $em = "A senha é um campo obrigatório";
        #REDIRECIONA PARA index.php E EMITE MENSAGEM DE ERRO
        header("location: ../../index.php?error=$em");
    } else {
        $query = "
            select * from
            tbuser where username = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);
        #IF THE USERNAME IS EXIST
        if ($stmt->rowCount() === 1) {
            #FETCHING USER DATA
            $user = $stmt->fetch();
            #IF BOTH USERNAME'S ARE STRICTLY EQUAL
            if ($user['username'] === $username) {
                # VERIFYING THE ENCRYPTED PASSWORD
                if (password_verify($password, $user['password'])) {
                    # SUCCESSFULLY LOGGED IN
                    #CREATING THE SESSION
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['user_id'] = $user['user_id'];

                    #REDIRECT TO 'home.php'
                    header("location:../../home.php");
                    exit;

                } else {
                    #MENSAGEM DE ERRO
                    $em = "Usuário ou senha errada";
                    #REDIRECIONA PARA index.php E EMITE MENSAGEM DE ERRO
                    header("location:../../index.php?error=$em");
                    exit;
                }

            } else {
                #MENSAGEM DE ERRO
                $em = "Usuário ou senha errada";
                #REDIRECIONA PARA index.php E EMITE MENSAGEM DE ERRO
                header("location:../../index.php?error=$em");
            }

        } else {
            $em = "Usuário ou senha errada";
            header("location: ../../index.php?error=$em");
            exit;
        }
    }
} else {
    header("location:../../index.php");
    exit;
}