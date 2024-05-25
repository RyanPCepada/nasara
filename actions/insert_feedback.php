
<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$products = $_POST['products'];
$services = $_POST['services'];
$convenience = $_POST['convenience'];
$rating = $_POST['rating'];



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
    $insertFeedback = $conn->prepare('INSERT INTO tbl_feedback (products, services, convenience, rating, customer_ID) VALUES (?, ?, ?, ?, ?)');
    $insertFeedback->execute([$products, $services, $convenience, $rating, $customerID]);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Sent feedback", $customerID]);

    $conn->commit();
    echo '<script>alert("Feedback Submitted!");';
    echo 'window.location.href = "http://localhost/nasara/home_main.php";</script>';

} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}
?>
















