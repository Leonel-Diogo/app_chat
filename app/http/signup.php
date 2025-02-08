<?php
# VERIFICA SE O NOME DE USUÁRIO, SENHA E NOME FORAM ENVIADOS
if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['name'])
) {
    # ARQUIVO DE CONEXÃO COM O BANCO DE DADOS
    include_once "../db-connect.php";

    # OBTÉM DADOS DO REQUEST POST E ARMAZENA-OS EM VARIÁVEIS
    $name = $_POST['name'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    # FORMATAÇÃO DOS DADOS PARA URL
    $data = 'name=' . $name . '&username=' . $username;

    # SIMPLES VALIDAÇÃO DE FORMULÁRIO
    if (empty($name)) {
        $em = "Nome é um campo obrigatório";
        header("location: ../../signup.php?error=$em&$data");
        exit;
    } else if (empty($username)) {
        $em = "Email é um campo obrigatório";
        header("location: ../../signup.php?error=$em&$data");
        exit;
    } else if (empty($password)) {
        $em = "A senha é um campo obrigatório";
        header("location: ../../signup.php?error=$em&$data");
        exit;
    } else {
        # VERIFICA NO BANCO DE DADOS SE O NOME DE USUÁRIO JÁ ESTÁ EM USO
        $query = "SELECT username FROM tbuser WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $em = "O nome de usuário ($username) já existe";
            header("location: ../../signup.php?error=$em&$data");
            exit;
        } else {
            print_r($_FILES['pfile']);
            # PROFILE PICTURE UPLOADING
            if (isset($_FILES['pfile']) && $_FILES['pfile']['error'] === 0) {
                # OBTÉM OS DADOS DO ARQUIVO
                $img_name = $_FILES['pfile']['name'];
                $tmp_name = $_FILES['pfile']['tmp_name'];
                $img_size = $_FILES['pfile']['size'];
                $img_error = $_FILES['pfile']['error'];

                # OBTÉM A EXTENSÃO DA IMAGEM
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                # EXTENSÕES PERMITIDAS
                $allowed_exs = array("jpg", "jpeg", "png");

                # VERIFICA SE A EXTENSÃO DA IMAGEM É PERMITIDA
                if (in_array($img_ex_lc, $allowed_exs)) {
                    # RENOMEIA A IMAGEM
                    $new_img_name = $username . '.' . $img_ex_lc;
                    $img_upload_path = '../../uploads/' . $new_img_name;

                    # VERIFICA SE A PASTA DE UPLOAD EXISTE, SENÃO CRIA
                    if (!is_dir('../../uploads')) {
                        mkdir('../../uploads', 0777, true);
                    }

                    # TENTA MOVER O ARQUIVO PARA O DESTINO
                    if (move_uploaded_file($tmp_name, $img_upload_path)) {
                        # SUCESSO NO UPLOAD
                    } else {
                        $em = "Erro ao mover o arquivo enviado.";
                        header("location: ../../signup.php?error=$em&$data");
                        exit;
                    }
                } else {
                    $em = "Você não pode enviar arquivos deste tipo! Permitido: jpg, jpeg, png.";
                    header("location: ../../signup.php?error=$em&$data");
                    exit;
                }
            } else {
                $em = "Nenhum arquivo foi enviado ou erro no envio.";
                header("location: ../../signup.php?error=$em&$data");
                exit;
            }
        }

        # CRIPTOGRAFIA DA SENHA
        $password = password_hash($password, PASSWORD_DEFAULT);

        if (isset($new_img_name)) {
            # INSERÇÃO DOS DADOS NO BANCO DE DADOS
            $query = "INSERT INTO tbuser(name, username, password, p_file) VALUES(?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$name, $username, $password, $new_img_name]);
        } else {
            # INSERÇÃO DOS DADOS NO BANCO DE DADOS
            $query = "INSERT INTO tbuser(name, username, password) VALUES(?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$name, $username, $password]);
        }

        # MENSAGEM DE SUCESSO
        $sm = "Conta criada com sucesso!";
        header("location: ../../index.php?success=$sm");
        exit;
    }
} else {
    header("location: ../../signup.php");
    exit;
}