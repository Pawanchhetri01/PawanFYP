<?php
include 'DatabaseConfig.php';
try {
    if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["otp"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $otp = $_POST["otp"];
        $sql = "SELECT * FROM users WHERE username = '$email'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $data = mysqli_fetch_assoc($result);
            $databasePassword = $data['password'];
            $userId = $data['id'];
            $role = $data['role'];
            $otpFromDatabase = $data['password_reset_code'];
            if ($otpFromDatabase == $otp) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = '$password' WHERE id = '$userId'";
                if ($result = mysqli_query($con, $query)) {
                    $data = ['success' => true, 'message' => 'Password Sucessfully updated!'];
                    echo json_encode($data);
                } else {
                    $data = ['success' => false, 'message' => 'Something went wrong!'];
                    echo json_encode($data);
                }
            } else {
                $data = ['success' => false, 'message' => 'OTP is incorrect!'];
                echo json_encode($data);
            }
    } else {
        $data = ['success' => false, 'message' => 'All the fields are required!'];
        echo json_encode($data);

    }
    }
} catch (\Throwable $th) {
    echo json_encode(
        [
            'success' => false,
            'message' => $th->getMessage()
        ]
    );
}
