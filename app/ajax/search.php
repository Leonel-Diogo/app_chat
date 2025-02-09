<?php
session_start(); // Certifique-se de que a sessão está ativa
if (isset($_SESSION['username'])) {
    #VERIFICANDO SE A CHAVE FOI SUBMETIDA
    if (isset($_POST['key'])) {
        #PEGANDO A INSTÂNCIA DA BD
        include_once "../db-connect.php";

        #ALGORITMO DE PESQUISA
        $key = "%{$_POST['key']}%";
        $query = "SELECT * FROM tbuser
                  WHERE username
                  LIKE ? OR name LIKE ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$key, $key]);

        #if (isset($_SESSION['user_id'])) {
        if ($stmt->rowCount() > 0) {
            $users = $stmt->fetchAll();
            foreach ($users as $user) {
                #print_r($_SESSION);
                if ($user['id_user'] == $_SESSION['user_id']) {
                    continue;
                }
                ?>
                <li class="list-group-item">
                    <a href="assets/image/chat.png?user=<?= $user['username'] ?>"
                        class="d-flex justify-content-center align-items-center p-2">
                        <div class="d-flex align-items-between">

                            <img src="uploads/<?= $user['p_file'] ?>" alt="" class="w-10 rounded-circle">

                            <h3 class="fs-xs m-2">
                                <?= $user['name'] ?>
                            </h3>
                        </div>
                    </a>
                </li>
            <?php }

        } else { ?>
            <div class="alert alert-info text-center" role="alert">
                <i class="fa fa-comments d-block fs-big"></i>
                <span>Usuário "<?= htmlspecialchars($_POST['key']) ?>" não encontrado</span>
            </div>
        <?php }
    }

} else {
    header('location: ../../index.php');
    exit;
}

?>