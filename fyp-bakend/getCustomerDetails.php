<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
  
    if( $_GET['customerId']){
            $customerId = $_GET['customerId'];
            //get the user details
            $getCustomerDetails="SELECT * FROM customers WHERE number = '$customerId'";
            $result = mysqli_query($con, $getCustomerDetails);
            $data=mysqli_fetch_assoc($result);
            if($data != null){
                echo json_encode(
                    [
                        'success' => true,
                        'message' => 'User found',
                        'data' => $data
                    ]
                );
            }else{
                echo json_encode(
                    [
                        'success' => false,
                        'message' => 'User not found'
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
?>



