<?php

include 'phpmailer/src/sendMail.php';

if(isset($_POST['email'])){

    $email = $_POST['email'];
    $check_email = "SELECT * FROM users WHERE username = '$email'";
    $result = mysqli_query($con, $check_email);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $name = mysqli_fetch_assoc($result)['name'];
        $digits = "0123456789";
        $OTP = "";
        for ($i = 0; $i < 4; $i++) {
            $OTP .= $digits[rand(0, strlen($digits) - 1)];
        }
        $sqlUpdate = "UPDATE users SET password_reset_code = '$OTP' WHERE username = '$email'";
        $result = mysqli_query($con, $sqlUpdate);
        if ($result) {
            $html = '
            <!DOCTYPE html>
            <html>
              <head>
                <meta charset="UTF-8">
                <title>Change Password OTP</title>
              </head>
              <body>
                <h1>Change Password OTP</h1>
                <p>Dear '.$name.',</p>
                <p>Your OTP to change the password is:</p>
                <h2>'.$OTP.'</h2>
                <p>Please use this OTP to reset your password within the next 10 minutes.</p>
                <p>If you did not request to change your password, please ignore this email and do not share the OTP with anyone.</p>
                <p>Best regards,</p>
                <p>Nexus Nepal</p>
              </body>
            </html>
            ';
            sendMailNexus($email, $html);
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'OTP sent to your email',
                    'otp' => $OTP
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Something went wrong'
                ]
            );
        }
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'User Not Found'
            ]
        );
    }



    
  
    


    


}
?>
