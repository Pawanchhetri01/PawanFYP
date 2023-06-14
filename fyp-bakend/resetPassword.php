<?php

header("Access-Control-Allow-Origin: *");

include './DatabaseConfig.php';
$connect = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

if (isset($_POST['password']) && isset($_POST['code']) && isset($_POST['email'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $code = $_POST['code'];
    $email = $_POST['email'];

    $sql = "SELECT * FROM users where email='$email' and password_reset_code='$code'";
    $result = mysqli_query($connect, $sql);
    if ($result->num_rows > 0) {
        $sql = "UPDATE users SET password='$password', password_reset_code=null where email='$email'";
        if (mysqli_query($connect, $sql)) {
            $data = ['success' => true, 'message' => ['Password updated successfully!']];
        } else {
            $data = ['success' => false, 'message' => ['Something went wrong!']];
        }
    } else {
        $data = ['success' => false, 'message' => ['Invalid code!']];
    }
    echo json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['All the fields are required!']];
    echo json_encode($data);
}
