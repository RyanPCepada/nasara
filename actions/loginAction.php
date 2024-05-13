<?php

require_once '../connection.php';

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$fetchCount = $conn->prepare('SELECT a.admin_ID FROM tbl_admin a WHERE a.email = ? AND a.password = ?');

$fetchCount->execute([$email, $password]);
$fetchCount_ = $fetchCount->fetch();

if ($fetchCount_) {
    $_SESSION['adm_user_ID'] = $fetchCount_['admin_ID'];
    $_SESSION['adminID'] = $fetchCount_['admin_ID']; // Set adminID in the session

    echo json_encode(['status' => 'success', 'role' => 'admin']);
} else {
    
    $fetchCount = $conn->prepare('SELECT a.customer_ID FROM tbl_customer_info a WHERE a.email = ? AND a.password = ?');
    $fetchCount->execute([$email, $password]);
    $fetchCount_ = $fetchCount->fetch();

    if ($fetchCount_) {
        $_SESSION['cus_user_ID'] = $fetchCount_['customer_ID'];
        $_SESSION['customerID'] = $fetchCount_['customer_ID']; // Set customerID in the session

        echo json_encode(['status' => 'success', 'role' => 'customer']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Login credentials do not exist.']);
    }

}

try {
    $conn->beginTransaction();

    if (isset($_SESSION['customerID'])) {
        $customerID = $_SESSION['customerID'];

        //tbl_activity_logs
        $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        $insertActivity->execute(["Logged in an account", $customerID]);
        
        $conn->commit();
    } else {
        // Handle the case where the customer is not logged in
        // echo "You must be logged in to submit feedback.";
    }
} catch (\Throwable $th) {
    echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
    $conn->rollBack();
}
?>
