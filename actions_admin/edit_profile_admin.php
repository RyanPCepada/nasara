<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$uname = $_POST['username'];

try {
    $conn->beginTransaction();
    
    if (isset($_SESSION['adminID'])) {
        $adminID = $_SESSION['adminID']; // Retrieve the adminID from the session
    } else {
        // Handle the case where the admin is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }


    // Update admin information in tbl_admin_info
    // $updateAccount = $conn->prepare('UPDATE tbl_admin_info 
    //     SET firstName = ?, middleName = ?, lastName = ?, street = ?, barangay = ?, municipality = ?, province = ?, zipcode = ?, birthDate = ?,
    //         gender = ?, phoneNumber = ?
    //     WHERE admin_ID = ?');
    // $updateAccount->execute([$fname, $mname, $lname, $st, $brgy, $mun, $prov, $zipc, $bdate, $gend, $pnum, $adminID]);

    // Update admin information in tbl_admin_info without changing the dateAdded
    $updateAccount = $conn->prepare('UPDATE tbl_admin
    SET userName = ?
    WHERE admin_ID = ?');
    $updateAccount->execute([$uname, $adminID]);

    // Insert an activity log in tbl_activity_logs
    // $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, admin_ID) VALUES (?, ?)');
    // $insertActivity->execute(["Updated the profile", $adminID]);

    $conn->commit();
    echo '<script>alert("Profile Updated Successfully!");';
    echo 'window.location.href = "http://localhost/DevBugs/admin_account.php";</script>';
} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}

?>


