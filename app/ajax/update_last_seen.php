<?php
/****************ESTADO DO USER*************/
echo "atualizando";
session_start();

#VERIFICANDO SE O USUÁRIO ESTÁ LOGADO
if (isset($_SESSION['username'])) {
    #PEGANDO A INSTÂNCIA DA BD
    include_once "db-connect.php";
    #PEGANDO O NOME DO USUÁRIO LOGADO DA SESSION
    $id = $_SESSION['id_user'];
    #QUERY
    $query = " UPDATE tb_user
                SET last_seen = NOW()
                WHERE  id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

} else {
    header('location: ../../index.php');
    exit;
}