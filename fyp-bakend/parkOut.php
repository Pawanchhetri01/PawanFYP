<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
// Creating MySQL Connection.


if (isset($_POST['parkingId'])){
    $parkingId = $_POST['parkingId'];
    $check_parkingId = "SELECT * FROM parkings WHERE id = $parkingId";
    $result = mysqli_query($con, $check_parkingId);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $data = mysqli_fetch_assoc($result);
        $park_in_time = $data['in_time'];
        $park_out_time = $data['out_time'];
        if($park_out_time != null){
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'Parking Already Out',
                    'data' => $data
                ]
            );
        }
        else{
            parkOut($parkingId, $park_in_time);
        } 
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Parking Not Found'
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
   