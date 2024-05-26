<?php
// delete_feedback.php

require 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Check if the provided ID corresponds to a written feedback or an audio feedback
    $sqlCheckFeedbackType = "SELECT feedback_ID FROM tbl_feedback WHERE feedback_ID = :id";
    $sqlCheckAudioType = "SELECT audio_ID FROM tbl_audio_feedback WHERE audio_ID = :id";

    $stmtCheckFeedbackType = $conn->prepare($sqlCheckFeedbackType);
    $stmtCheckFeedbackType->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtCheckFeedbackType->execute();
    $isWrittenFeedback = $stmtCheckFeedbackType->fetch(PDO::FETCH_ASSOC);

    $stmtCheckAudioType = $conn->prepare($sqlCheckAudioType);
    $stmtCheckAudioType->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtCheckAudioType->execute();
    $isAudioFeedback = $stmtCheckAudioType->fetch(PDO::FETCH_ASSOC);

    if ($isWrittenFeedback) {
        // Delete written feedback if the ID corresponds to a written feedback
        $sqlDeleteWrittenFeedback = "DELETE FROM tbl_feedback WHERE feedback_ID = :id";
        $stmtDeleteWrittenFeedback = $conn->prepare($sqlDeleteWrittenFeedback);
        $stmtDeleteWrittenFeedback->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmtDeleteWrittenFeedback->execute()) {
            header("Location: account_main.php");
            exit;
        } else {
            echo "Failed to delete written feedback.";
        }
    } elseif ($isAudioFeedback) {
        // Delete audio feedback if the ID corresponds to an audio feedback
        $sqlDeleteAudioFeedback = "DELETE FROM tbl_audio_feedback WHERE audio_ID = :id";
        $stmtDeleteAudioFeedback = $conn->prepare($sqlDeleteAudioFeedback);
        $stmtDeleteAudioFeedback->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmtDeleteAudioFeedback->execute()) {
            header("Location: account_main.php");
            exit;
        } else {
            echo "Failed to delete audio feedback.";
        }
    } else {
        echo "Invalid feedback ID.";
    }
}
?>
