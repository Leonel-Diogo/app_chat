<?php
/*session_start();
if (isset($_SESSION['id_user'])) {
    require_once '../db-connect.php';

    $id = $_SESSION['id_user'];
    $query = "UPDATE tbuser SET last_seen = NOW() WHERE id_user = ?";

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado']);
} */