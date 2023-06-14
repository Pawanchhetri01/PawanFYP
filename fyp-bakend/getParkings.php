<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

if(isset($_POST['type']) && isset($_POST['merchant_id'])){
    try {
        $type=$_POST['type'];
        $merchant_id=$_POST['merchant_id'];
        //check it the merchant is admin
        $sql = "SELECT * FROM users WHERE id = '$merchant_id' AND role = 'admin'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $merchant_id = null;
        }
        $sql = $merchant_id!=null ?rageFromType($type, $merchant_id) : rageFromTypeAdmin($type);
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
                    'message' => "Parkings fetched successfully"
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
    } catch (\Throwable $th) {
        echo json_encode(
            [
                'success' => false,
                'message' => $th->getMessage(),
                'sql' => $sql
            ]
        );
    }
   
}else{
    echo json_encode(
        [
            'success' => false,
            'message' => 'Missing some payload',
            
        ]
    );
}


function rageFromType($type, $merchant_id){
    $sql = "";
    switch ($type) {
        ///today
        case '1':
            $sql = "SELECT * FROM parkings where merchant_id='$merchant_id' and out_time<now() and out_time>now()-interval 1 day";  
            break;
        ///week
        case '2':
            $sql = "SELECT * FROM parkings where merchant_id='$merchant_id' and out_time<now() and out_time>now()-interval 1 week";  
            break;
        ///month
        case '3':
            $sql = "SELECT * FROM parkings where merchant_id='$merchant_id' and out_time<now() and out_time>now()-interval 1 month";  
            break;
        ///year
        case '4':
            $sql = "SELECT * FROM parkings where merchant_id='$merchant_id' and out_time<now() and out_time>now()-interval 1 year";  
            break;
        ///all
        case '5':
            $sql = "SELECT * FROM parkings where merchant_id='$merchant_id' and out_time<now()";  
            break;
        default:
            $sql = "SELECT * FROM parkings where merchant_id='$merchant_id' and out_ime<now()";  
            break; 
    }
    return $sql;
}

//range for admin
function rageFromTypeAdmin($type){
    $sql = "";
    switch ($type) {
        ///today
        case '1':
            $sql = "SELECT * FROM parkings where out_time<now() and out_time>now()-interval 1 day";  
            break;
        ///week
        case '2':
            $sql = "SELECT * FROM parkings where out_time<now() and out_time>now()-interval 1 week";  
            break;
        ///month
        case '3':
            $sql = "SELECT * FROM parkings where out_time<now() and out_time>now()-interval 1 month";  
            break;
        ///year
        case '4':
            $sql = "SELECT * FROM parkings where out_time<now() and out_time>now()-interval 1 year";  
            break;
        ///all
        case '5':
            $sql = "SELECT * FROM parkings where out_time<now()";  
            break;
        default:
            $sql = "SELECT * FROM parkings where out_ime<now()";  
            break; 
    }
    return $sql;
}