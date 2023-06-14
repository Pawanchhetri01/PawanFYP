<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
try {
    if ($isAdmin) {
        $merchantEmail = $_POST['email'];
        $action = $_POST['action'];
        if($action=='suspend')
            suspendMerchant($merchantEmail);
        else if($action=='unsuspend')
            unsuspendMerchant($merchantEmail);
        else
            echo json_encode(['success'=>false, 'message'=>'Invalid action']);
    }else{
        echo json_encode(['success'=>false, 'message'=>'You are not authorized to perform this action']);
    }
} catch (\Throwable $th) {
    echo json_encode(['success'=>false, 'message'=>$th->getMessage()]);
}

   
function suspendMerchant($merchantEmail){
    global $con;
    $sql = "UPDATE users SET active = '0' WHERE username = '$merchantEmail'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data=['success'=>true, 'message'=>'Merchant suspended successfully'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>$con->error];
        echo json_encode($data);
    }
}

function unsuspendMerchant($merchantEmail){
    global $con;
    $sql = "UPDATE users SET active = '1' WHERE username = '$merchantEmail'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data=['success'=>true, 'message'=>'Merchant unsuspended successfully'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>$con->error];
        echo json_encode($data);
    }
}

