
<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$adminreply = $_POST['admin_reply'];
$messageID = $_POST['message_ID'];
$customerID = $_POST['customer_ID'];

try {
    $conn->beginTransaction();


    if (isset($_SESSION['adminID'])) {
        $adminID = $_SESSION['adminID']; // Retrieve the adminID from the session
    } else {
        // Handle the case where the admin is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }

    // First, you need to insert the feedback into tbl_feedback with the retrieved admin ID
    $insertReply = $conn->prepare('INSERT INTO tbl_reply (reply, message_ID, customer_ID, admin_ID) VALUES (?, ?, ?, ?)');
    $insertReply->execute([$adminreply, $messageID, $customerID, $adminID]);

    // Insert an activity log in tbl_activity_logs
    // $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, admin_ID) VALUES (?, ?)');
    // $insertActivity->execute(["Sent a message", $adminID]);

    $conn->commit();
    echo '<script>alert("Message Sent!");';
    echo 'window.location.href = "http://localhost/DevBugs/admin_main.php";</script>';

} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}
?>
















