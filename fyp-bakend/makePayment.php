<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
// Creating MySQL Connection.

$tokenCheck=checkIdValidUser($_GET['token']??null);
    if(isset($_GET['token']) && $tokenCheck != null){
            $userId=$tokenCheck;
            if (isset($_POST['amount'])&&isset($_POST['date'])  ) {
                //create payment
                $amount=$_POST['amount'];
                $date=$_POST['date'];
                $merchant_id=$_POST['merchant_id'];

                
                $created_at = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `payments` (`id`, `user_id`, `merchant_id`, `amount`, `date`, `created_at`) VALUES (NULL, NULL, '$merchant_id', '$amount', '$date', '$created_at')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo json_encode(
                        [
                            'success' => true,
                            'message' =>'Payment was successful'
                        ]
                    );
                } else {
                    echo json_encode(
                        [
                            'success' => false,
                            'message' =>'Payment failed'
                        ]
                    );
                }
                
    
            }else{
                echo json_encode(
                    [
                        'success' => false,
                        'message' =>'Missing some data'
                    ]
                );
            }
    }else{
        echo json_encode(
            [
                'success' => false,
                'message' =>'Access denied'
            ]
        );
    }
if (isset($_POST['token']) && isset($_POST['merchant_id'])&&isset($_POST['amount'])&&isset($_POST['date'])  ) {

    
}


