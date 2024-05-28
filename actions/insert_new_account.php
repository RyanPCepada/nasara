<?php
require_once '../connection.php';

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$pword = $_POST['password'];
$confirmpword = $_POST['confirmpassword'];

// Default profile picture path
$defaultProfilePicture = "profpic.png";

if ($pword == $confirmpword) {

    try {
        $conn->beginTransaction();

        if (isset($_SESSION['customerID'])) {
            $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
        } 
        
        // Insert into tbl_customer_info
        $insertNewAccount = $conn->prepare('INSERT INTO tbl_customer_info (firstName, lastName, email, password, image) 
        VALUES (?, ?, ?, ?, ?)');
        $insertNewAccount->execute([$fname, $lname, $email, $pword, $defaultProfilePicture]); // Insert default profile picture

        $customerID = $conn->lastInsertId(); 

        // Insert into tbl_activity_logs
        $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        $insertActivity->execute(["Registered an account", $customerID]);

        $conn->commit();
        echo '<script>alert("Registered Successfully!");';
        echo 'window.location.href = "http://localhost/nasara/login_main.php";</script>';

    } catch (\Throwable $th) {
        echo $th;
        $conn->rollBack();
    }

} else {
    echo '<script>alert("Passwords do not match!");';
    echo 'window.location.href = "http://localhost/nasara/register.php";</script>';
}
?>
