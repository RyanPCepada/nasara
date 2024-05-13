<?php

require_once '../connection.php';

session_start();  // Start the session to access session variables

try {
    $conn->beginTransaction();

    if (isset($_SESSION['customerID'])) {
        $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
    } else {
        // Handle the case where the customer is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }

    // Handle the received audio data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $audio = file_get_contents("php://input");

        // Insert the audio data into tbl_voice_feedback with the retrieved customer ID
        $insertAudio = $conn->prepare('INSERT INTO tbl_audio_feedback (audio, dateAdded, customer_ID) VALUES (?, NOW(), ?)');
        $insertAudio->execute([$audio, $customerID]);

        // Insert an activity log in tbl_activity_logs
        $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
        $insertActivity->execute(["Sent audio feedback", $customerID]);

        $conn->commit();
        echo "Audio feedback stored successfully.";
    } else {
        echo "Invalid request method.";
    }

} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}
?>
