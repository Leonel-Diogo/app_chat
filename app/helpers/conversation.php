<?php
function getConversation($id_user, $conn)
{
    /*GETTING ALL THE CONVERSATIONS FOR CURRENT(LOGGED IN) USER */
    $query = "SELECT * from tbconversation
    where user_1 = ? or user_2 = ?
    order by id_consversation desc
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([$id_user, $id_user]);

    if ($stmt->rowCount() > 0) {
        $conversations = $stmt->fetchAll();

        #CREATE EMPTY ARRAY TO STORE THE USER CONVERSATION
        $user_data = [];
        #LOOPING THROUGH THE CONVERSATIONS
        foreach ($conversations as $conversation) {
            # IF CONVERSATIONS USER_1 ROW EQUAL TO USER_ID
            if ($conversation['user_1'] == $id_user) {
                # code...
                $query2 = "SELECT name, username, p_file, last_seen
                from tbuser where id_user = ?";

                $stmt2 = $conn->prepare($query2);
                $stmt2->execute([$conversation['user_2']]);
            } else {
                # code...
                $query2 = "SELECT name, username, p_file, last_seen
                from tbuser where id_user = ?";
                $stmt2 = $conn->prepare($query2);
                $stmt2->execute([$conversation['user_1']]);
            }
            $allConversations = $stmt2->fetchAll();
            #PUSHIING THE DATA INTO THE ARRAY
            array_push($user_data, $allConversations[0]);
        }
        return $user_data;

    } else {
        $conversations = [];
        return $conversations;
    }

}