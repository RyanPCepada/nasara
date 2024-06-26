<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

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

// Combine the values into a single date string in YYYY-MM-DD format
$bdate = "$year-$month-$day";
    
$gend = $_POST['gender'];
$pnum = $_POST['phonenumber'];
// $email = $_POST['email'];
// $pword = $_POST['password'];

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


    // Update customer information in tbl_customer_info
    // $updateAccount = $conn->prepare('UPDATE tbl_customer_info 
    //     SET firstName = ?, middleName = ?, lastName = ?, street = ?, barangay = ?, municipality = ?, province = ?, zipcode = ?, birthDate = ?,
    //         gender = ?, phoneNumber = ?
    //     WHERE customer_ID = ?');
    // $updateAccount->execute([$fname, $mname, $lname, $st, $brgy, $mun, $prov, $zipc, $bdate, $gend, $pnum, $customerID]);

    // Update customer information in tbl_customer_info without changing the dateAdded
    $updateAccount = $conn->prepare('UPDATE tbl_customer_info 
    SET firstName = ?, middleName = ?, lastName = ?, street = ?, barangay = ?, municipality = ?, province = ?, zipcode = ?, birthDate = ?,
        gender = ?, phoneNumber = ?, dateModified = NOW()
    WHERE customer_ID = ?');
    $updateAccount->execute([$fname, $mname, $lname, $st, $brgy, $mun, $prov, $zipc, $bdate, $gend, $pnum, $customerID]);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Updated the profile", $customerID]);

    $conn->commit();
    echo '<script>alert("Profile Updated Successfully!");';
    echo 'window.location.href = "http://localhost/nasara/account_main.php";</script>';
} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}

?>


