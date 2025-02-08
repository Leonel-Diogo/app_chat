<?php
function getUser($username, $conn)
{
    $query = "select * from tbuser where username = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        return $user;
    } else {
        $user = [];
        return $user;
    }

}
?>