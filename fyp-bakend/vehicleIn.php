<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
// Creating MySQL Connection.


if (isset($_POST['customerId']) && isset($_POST['customerName']) && isset($_POST['number']) && isset($_POST['merchant_id'])) {

    try {
        $customerId = $_POST['customerId'];
        $customerName = $_POST['customerName'];
        $number = $_POST['number'];
        $merchant_id = $_POST['merchant_id'];


        //check if the email is already in the database
        $check_customerId = "SELECT * FROM customers WHERE number = $number";
        $result = mysqli_query($con, $check_customerId);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            parkIn($customerId, $merchant_id);
        } else {
            // addMerchant($email, $password, $name, $phone);
            //   vehicleIn($customerId, $customerName, $number);
            vehicleIn($customerId, $customerName, $number, $merchant_id);
        }
    } catch (\Throwable $th) {
        echo json_encode(
            [
                'message' => $th->getMessage(),
                'success' => false,
            ]
        );
    }
} else {
    echo json_encode(
        [
            'message' => 'Please fill all the fields.',
            'success' => false
        ]
    );
}
