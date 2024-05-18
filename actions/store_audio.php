<?php

session_start();

if (isset($_SESSION['customerID'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nasara";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $customerID = $_SESSION['customerID'];

        // Check if the user submitted a new audio file
        if (isset($_FILES['audioData']) && $_FILES['audioData']['name']) {
            $audioName = $_FILES['audioData']['name'];
            $audioSize = $_FILES['audioData']['size'];
            $tmpName = $_FILES['audioData']['tmp_name'];

            // Add audio validation logic here
            $validAudioExtensions = ['mp3', 'wav'];
            $audioExtension = pathinfo($audioName, PATHINFO_EXTENSION);
            $audioExtension = strtolower($audioExtension);
            
            if (!in_array($audioExtension, $validAudioExtensions)) {
                echo "Error: Invalid audio extension. Only MP3 and WAV are allowed.";
            } elseif ($audioSize > 10000000) { // 10MB max
                echo "Error: Audio size is too large (max 10MB).";
            } else {
                // Generate a unique file name for the new audio
                $newAudioName = $customerID . '_' . date("Y.m.d") . '_' . date("h.i.sa") . '.' . $audioExtension;

                // Save the audio to your server
                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/nasara/audios/' . $newAudioName;
                move_uploaded_file($tmpName, $uploadPath);

                // Insert the audio file name into tbl_audio_feedback
                $insertAudio = $conn->prepare('INSERT INTO tbl_audio_feedback (audio, dateAdded, customer_ID) VALUES (:audio, NOW(), :customerID)');
                $insertAudio->bindParam(':audio', $newAudioName);
                $insertAudio->bindParam(':customerID', $customerID);
                $insertAudio->execute();

                // Insert an activity log in tbl_activity_logs
                $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
                $insertActivity->execute(["Sent audio feedback", $customerID]);

                // Redirect to the user's profile page
                echo '<script>window.location.href = "http://localhost/nasara/account_main.php";</script>';
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
} else {
    echo "You must be logged in to submit audio feedback.";
    exit();
}
?>
