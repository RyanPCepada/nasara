<?php
session_start();

if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];

    // Store "Logged out an account" in tbl_activity_logs
    require_once '../connection.php';

    try {
        $conn->beginTransaction();

        $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        $insertActivity->execute(["Logged out an account", $customerID]);

        $conn->commit();
    } catch (\Throwable $th) {
        echo $th;
        $conn->rollBack();
    }

    // // Clear the session
    // session_unset();
    // session_destroy();

    // Clear the customer session
    unset($_SESSION['customerID']);
    session_destroy();

    // Display an alert using JavaScript
    echo '<script>alert("You are logged out."); window.location.href = "http://localhost/nasara/login_main.php";</script>';
} else {
    // Display an alert using JavaScript
    echo '<script>alert("You must be logged in to log out."); window.location.href = "http://localhost/nasara/login_main.php";</script>';
}
?>
