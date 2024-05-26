<?php
// delete_feedback.php

require 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM tbl_feedback WHERE feedback_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: feedback_page.php");
        exit;
    } else {
        echo "Failed to delete feedback.";
    }
}
?>
