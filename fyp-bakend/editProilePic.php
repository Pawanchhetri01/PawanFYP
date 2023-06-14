<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$tokenCheck=checkIdValidUser($_POST['token']??null);
$user_data = array();

if (isset($_POST['token']) && isset($_FILES['image'])) {
    $userId = $tokenCheck;

    $img_loc = null;

    if (isset($_FILES['image'])) {
        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            if ($img_size > 125000) {
                $em = "Sorry, your file is too large.";
                $data = ['success' => false, 'message' => [$em]];
                echo json_encode($data);
                exit();
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png"); // allowed extensions

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = 'uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Insert into Database
                    $img_loc = $img_upload_path;
                } else {
                    $em = "You can't upload files of this type";
                    $data = ['success' => false, 'message' => [$em]];
                    echo json_encode($data);
                    exit();
                }
            }
        } else {
            $em = "unknown error occurred!";
            $data = ['success' => false, 'message' => [$em]];
            echo json_encode($data);
            exit();
        }
    }

    $updateDetails = "UPDATE users set image = '$img_loc' where id = '$userId'";

    if (mysqli_query($connect, $updateDetails)) {
        $data = ['success' => true, 'message' => ['Successfully updated!'], 'data' => $img_loc];
        echo json_encode($data);
    } else {
        $data = ['success' => false, 'message' => ['Something went wrong!']];
        echo json_encode($data);
    }
} else {
    $data = ['success' => false, 'message' => ['UserId required']];
    echo json_encode($data);
}
