<?php
session_start(); // Start the session to access session variables

// Check if the admin is logged in
if (isset($_SESSION['adminID'])) {
    // Replace these database connection details with your own
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nasara";

    try {
        // Create a PDO connection to your database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if a feedback ID is provided
        if (isset($_GET['feedback_id']) && isset($_GET['customer_ID'])) {
            // Sanitize and retrieve the feedback ID and customer ID
            $feedback_id = intval($_GET['feedback_id']);
            $customer_ID = intval($_GET['customer_ID']);

            // Perform the deletion from the database
            $query = $conn->prepare("DELETE FROM tbl_feedback WHERE feedback_ID = :feedback_id");
            $query->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
            $query->execute();

            // Redirect back to view_customer.php after successful deletion
            header("Location: view_customer.php?customer_ID=" . $customer_ID);
            exit();
        } else {
            echo "No feedback ID or customer ID provided.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    // Handle the case where the admin is not logged in
    echo "You must be logged in as an admin to perform this action.";
    exit(); // Exit the script
}
?>
