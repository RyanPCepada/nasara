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
        
        if (isset($_SESSION['adminID'])) {
            $adminID = $_SESSION['adminID']; // Retrieve the adminID from the session
        } else {
            // Handle the case where the admin is not logged in
            echo "You must be logged in to submit feedback.";
            exit(); // Exit the script
        }

        ////Update admin information in tbl_admin_info
        // $updatePassword = $conn->prepare('UPDATE tbl_admin_info 
        //     SET password = ?
        //     WHERE admin_ID = ?');
        // $updatePassword->execute([$newPassword, $adminID]);

        // Update admin information in tbl_admin_info without changing the dateAdded
        $updatePassword = $conn->prepare('UPDATE tbl_admin 
        SET password = ?
        WHERE admin_ID = ?');
        $updatePassword->execute([$newPassword, $adminID]);

        // Insert an activity log in tbl_activity_logs
        // $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, admin_ID) VALUES (?, ?)');
        // $insertActivity->execute(["Changed the password", $adminID]);

        $conn->commit();

        // echo '<script>alert("' . $password . '");</script>';
        echo '<script>alert("Password Changed Successfully!");';
        echo 'window.location.href = "http://localhost/DevBugs/admin_account.php";</script>';
    } catch (\Throwable $th) {
        echo $th;
        $conn->rollBack();
    }

}else{
    
}

?>


