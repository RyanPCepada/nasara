
<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$cnum = $_POST['contactnum'];
$mess = $_POST['message'];

try {
    $conn->beginTransaction();


    if (isset($_SESSION['customerID'])) {
        $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
    } else {
        // Handle the case where the customer is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }

    // First, you need to insert the feedback into tbl_feedback with the retrieved customer ID
    $insertMessage = $conn->prepare('INSERT INTO tbl_message (firstName, lastName, email, contactNumber, message, customer_ID) VALUES (?, ?, ?, ?, ?, ?)');
    $insertMessage->execute([$fname, $lname, $email, $cnum, $mess, $customerID]);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Sent a message", $customerID]);

    $conn->commit();
    echo '<script>alert("Message Sent!");';
    echo 'window.location.href = "http://localhost/nasara/account_main.php";</script>';

} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}
?>
















