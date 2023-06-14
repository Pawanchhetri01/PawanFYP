<?php

header("Access-Control-Allow-Origin: *");

include './DatabaseConfig.php';
$connect = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

if (isset($_POST['user_id']) && isset($_POST['otp'])) {

    $user_id = $_POST['user_id'];
    $otp = $_POST['otp'];


    $sql = "SELECT * FROM users where user_id='$user_id'";
    $result = mysqli_query($connect, $sql);
    if ($row = mysqli_fetch_array($result)) {
        if ($row['verification_code'] == $otp) {
            $sql = "UPDATE users SET verification_code=null where user_id='$user_id'";
            if (mysqli_query($connect, $sql)) {
                $data = ['success' => true, 'message' => ['OTP verified successfully!']];
            } else {
                $data = ['success' => false, 'message' => ['Something went wrong!']];
            }
        } else if ($row['verification_code'] == null) {
            $data = ['success' => true, 'message' => ['User already verified!']];
        } else {
            $data = ['success' => false, 'message' => ['Invalid OTP!']];
        }
    } else {
        $data = ['success' => false, 'message' => ['Invalid OTP!']];
    }

    echo json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['All the fields are required!']];
    echo json_encode($data);
}
