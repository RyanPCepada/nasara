<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$customerID = $_POST['customer_ID'];
$fname = $_POST['firstname'];
$mname = $_POST['middlename'];
$lname = $_POST['lastname'];
$st = $_POST['street'];
$brgy = $_POST['barangay'];
$mun = $_POST['municipality'];
$prov = $_POST['province'];
$zipc = $_POST['zipcode'];

$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$bdate = "$year-$month-$day";
    
$gend = $_POST['gender'];
$pnum = $_POST['phonenumber'];

// $email = $_POST['email'];
// $pword = $_POST['password'];

// $confirmpword = $_POST['confirmpassword'];
try {
    $conn->beginTransaction();
    
    if (isset($_SESSION['adminID'])) {
        $adminID = $_SESSION['adminID']; // Retrieve the adminID from the session
    } else {
        // Handle the case where the customer is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }

    // Update customer information in tbl_customer_info without changing the dateAdded
    $updateAccount = $conn->prepare('UPDATE tbl_customer_info 
    SET firstName = ?, middleName = ?, lastName = ?, street = ?, barangay = ?, municipality = ?, province = ?, zipcode = ?, birthDate = ?,
        gender = ?, phoneNumber = ?,  dateAdded = dateAdded, dateModified = NOW()
    WHERE customer_ID = ?');
    $updateAccount->execute([$fname, $mname, $lname, $st, $brgy, $mun, $prov, $zipc, $bdate, $gend, $pnum, $customerID]);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Admin updated the profile", $customerID]);

    $conn->commit();
    echo '<script>alert("Customer Profile Updated Successfully!");';
    echo 'window.location.href = "http://localhost/DevBugs/admin_main.php";</script>';
} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}

?>


