<?php
header("Access-Control-Allow-Origin: *");

include './mailing.php';
include './generateOTP.php';
include 'DatabaseConfig.php';
$connect = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

if (isset($_POST['username']) && isset($_POST['type'])) {
    $username = $_POST['username'];
    $type = $_POST['type'];
    $otp = generateOTP();

    sendMail('OTP ', 'pawankunwar954@gmail.com', 'Pawan Kunwar', $otp);
    if ($type == 'verify') {
        $sql = "UPDATE users SET verification_code='$otp' where username='$username'";
    } else {
        $sql = "UPDATE users SET password_reset_code='$otp' where username='$username'";
    }
    if (mysqli_query($connect, $sql)) {
        $data = ['success' => true, 'message' => ['OTP sent successfully!']];
    } else {
        $data = ['success' => false, 'message' => ['Something went wrong!']];
    }
    echo json_encode($data);
} else {
    $data = ['success' => false, 'message' => ['All the fields are required!']];
    echo json_encode($data);
}
