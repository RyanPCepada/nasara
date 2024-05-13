<?php
session_start();

if (isset($_SESSION['adminID'])) {
    $adminID = $_SESSION['adminID'];

    // Store "Logged out an account" in tbl_activity_logs
    require_once '../connection.php';

    try {
        $conn->beginTransaction();

        // $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, admin_ID) VALUES (?, ?)');
        // $insertActivity->execute(["Logged out an account", $adminID]);

        $conn->commit();
    } catch (\Throwable $th) {
        echo $th;
        $conn->rollBack();
    }

    // // Clear the session
    // session_unset();
    // session_destroy();

    // Clear the admin session
    unset($_SESSION['adminID']);
    session_destroy();

    // Display an alert using JavaScript
    echo '<script>alert("You are logged out."); window.location.href = "http://localhost/DevBugs/login_main.php";</script>';
} else {
    // Display an alert using JavaScript
    echo '<script>alert("You must be logged in to log out."); window.location.href = "http://localhost/DevBugs/login_main.php";</script>';
}
?>

