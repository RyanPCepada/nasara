<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$oldPassword = $_POST['oldpassword'];
$newPassword = $_POST['newpassword'];
$confirmNewPassword = $_POST['confirmnewpassword'];



if ($newPassword == $confirmNewPassword) {
// $confirmpword = $_POST['confirmpassword'];
    try {
        $conn->beginTransaction();
        
        if (isset($_SESSION['customerID'])) {
            $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
        } else {
            // Handle the case where the customer is not logged in
            echo "You must be logged in to submit feedback.";
            exit(); // Exit the script
        }

        ////Update customer information in tbl_customer_info
        // $updatePassword = $conn->prepare('UPDATE tbl_customer_info 
        //     SET password = ?
        //     WHERE customer_ID = ?');
        // $updatePassword->execute([$newPassword, $customerID]);

        // Update customer information in tbl_customer_info without changing the dateAdded
        $updatePassword = $conn->prepare('UPDATE tbl_customer_info 
        SET password = ?, dateModified = NOW(), dateAdded = dateAdded
        WHERE customer_ID = ?');
        $updatePassword->execute([$newPassword, $customerID]);

        // Insert an activity log in tbl_activity_logs
        $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        $insertActivity->execute(["Changed the password", $customerID]);

        $conn->commit();
        echo '<script>alert("Password Changed Successfully!");';
        echo 'window.location.href = "http://localhost/nasara/account_main.php";</script>';
    } catch (\Throwable $th) {
        echo $th;
        $conn->rollBack();
    }

}else{
    
}

?>


