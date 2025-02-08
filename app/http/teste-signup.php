<?php
#CHECK IF USERNAME, PASSWORD, NAME SUBMITTED
if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['name'])
) {
    #DATABASE CONNECTION FILE
    include_once "../db-connect.php";

    #GET DATA FROM post REQUEST AND STORE THEM IN VAR
    $name = $_POST['name'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    #MAKING URL DATA FORMAT
    $data = 'name=' . $name . '&username=' . $username;

    #SIMPLE FORM VALIDATION
    if (empty($name)) {
        $em = "Nome é um campo obrigatório";

        #REDIRECT TO 'signup.php' and passing error message
        header("location: ../../signup.php?error=$em&$data");
        exit;
    } else if (empty($username)) {
        $em = "Email é um campo obrigatório";

        #REDIRECT TO 'signup.php' and passing error message
        header("location: ../../signup.php?error=$em&$data");
        exit;
    } else if (empty($password)) {
        $em = "A senha é um campo obrigatório";

        #REDIRECT TO 'signup.php' and passing error message and data
        header("location: ../../signup.php?error=$em&$data");
        exit;
    } else {
        #CHEKING THE database IF USERNAME IS TAKEN
        $query = "
            select username
            from tbuser
            where username = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $em = "The username ($username) is taken";
            header("location: ../../signup.php?error=$em&$data");
            exit;
        } else {
            if (isset($_FILES['p_file'])) {
                #GET data AND STORE THEM IN VAR
                $img_name = $_FILES['p_file']['name'];
                $tmp = $_FILES['p_file']['tmp_name'];
                $error = $_FILES['p_file']['error'];

                #IF THERE IS NOT ERROR OCURRED WHILE UPLOADING
                if ($error === 0) {
                    # GET image EXTENSION STORE IT IN VAR
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    /*CONVERT THE image EXTENSION INTO LOWER CASE AND STORE IT IN VAR */
                    $img_ex_lc = strtolower($img_ex);
                    #CREATE ARRAY THAT STORE ALLOWED TO UPLOAD image EXTENSION
                    $allowed_exs = array("jpg", "jpeg", "png");

                    #CHEK IF THE image EXTENSION IS PRESENT IN $allowed_exs ARRAY
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        #RENAMING THE image WITH USER'S USERNAME LIKE: username.$img_ex_lc
                        $new_img_name = $username . '.' . $img_ex_lc;
                        #CREATING UPLOAD PATH ON ROOT DIRECTORY
                        $img_upload_path = '../../uploads/' . $new_img_name;
                        #MOVE UPLOADED image TO ./upload FOLDER
                        move_uploaded_file($tmp_name, $img_upload_path);
                    } else {
                        $em = "You can't upload files of this type!";
                        header("location: ../../signup.php?error=$em&$data");
                        exit;
                    }
                }
            } else {
                $em = "Unknow error ocorred!";
                header("location: ../../signup.php?error=$em&$data");
                exit;
            }
        }
        #PASSWORD HASSHING
        $password = password_hash($password, PASSWORD_DEFAULT);

        #IF THE USER UPLOAD PROFILE PICTURE
        if (isset($new_img_name)) {
            #INSERT DATA INTO DATABASE
            $query = "
                insert into tbuser(name, username, password, p_file)
                values(?, ?, ?, ?)
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute([$name, $username, $password, $new_img_name]);
        } else {
            #INSERT DATA INTO DATABASE
            $query = "
                insert into tbuser(name, username, password)
                values(?, ?, ?)
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute([$name, $username, $password]);
        }
        #SUCCESS MESSAGE
        $sm = "Conta criada com sucesso!";

        #REDIRECT TO index.php AND PASSING SUCCESS MESSAGE
        header("location: ../../index.php?error=$em");
        exit;
    }
} else {
    header("location: ../../signup.php?success=$sm");
    exit;
}