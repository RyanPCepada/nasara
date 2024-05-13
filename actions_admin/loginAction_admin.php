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

    echo 'Login Successfully!';
} else {
    echo 'Login credentials do not exist.';
}

try {
    $conn->beginTransaction();

    if (isset($_SESSION['adminID'])) {
        $adminID = $_SESSION['adminID'];

        //tbl_activity_logs
        // $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        // $insertActivity->execute(["Logged in an account", $customerID]);
        
        $conn->commit();
    } else {
        // Handle the case where the customer is not logged in
        // echo "You must be logged in to submit feedback.";
    }
} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}
?>
