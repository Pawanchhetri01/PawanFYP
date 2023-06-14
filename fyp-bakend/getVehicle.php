<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
//get customers from the database
 $categories = "SELECT * FROM customers";
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
                'message' => "Vehicles fetched successfully"
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching Vehicles'
            ]
        );
    }