<?php
require_once '../connection.php';

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$pword = $_POST['password'];
$confirmpword = $_POST['confirmpassword'];


if ($pword == $confirmpword) {

    try {
        $conn->beginTransaction();

        if (isset($_SESSION['customerID'])) {
            $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
        } 

        // //tbl_user_type_access
        // $insertUserType = $conn->prepare('INSERT INTO tbl_user_type_access (accessType) VALUES (?)');
        // $insertUserType->execute(["User"]);

        // $accesstypeID = $conn->lastInsertId(); 
        
        //tbl_customer_info
        $insertNewAccount = $conn->prepare('INSERT INTO tbl_customer_info (firstName, lastName, email, password, image) 
        VALUES (?, ?, ?, ?, ?)');
        $insertNewAccount->execute([$fname, $lname, $email, $pword, "2_2024.05.05_04.48.56pm"]); // Assumes auto-generated ID

        $customerID = $conn->lastInsertId(); 

        //tbl_activity_logs
        $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        $insertActivity->execute(["Registered an account", $customerID]);

        //tbl_background_info
        // $insertAccount = $conn->prepare('INSERT INTO tbl_background_info 
        // (bio, hobby1, hobby2, hobby3, hobby4, favorite1, favorite2, favorite3, favorite4, dateModified, customer_ID) 
        // VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        // $insertAccount->execute(["", "", "", "", "", "", "", "", "", $dateModified, $customerID]);

        $conn->commit();
        echo '<script>alert("Registered Successfully!");';
        echo 'window.location.href = "http://localhost/nasara/login_main.php";</script>';

    } catch (\Throwable $th) {
        echo $th;
        $conn->rollBack();
    }

}else{
    
}

?>
