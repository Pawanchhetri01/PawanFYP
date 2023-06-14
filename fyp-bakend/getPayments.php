<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
//get customers from the database

if(isset($_POST['merchant_id'])){
    $merchant_id=$_POST['merchant_id'];
    $sql = "SELECT * FROM payments join users on payments.merchant_id=users.id where payments.merchant_id='$merchant_id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => "Payments fetched successfully"
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching Payments'
            ]
        );
    }
}else{
    $categories = "SELECT * FROM payments join users on payments.merchant_id=users.id";
    $result = mysqli_query($con, $categories);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => "All Payments fetched successfully"
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching Payments'
            ]
        );
    }
}
