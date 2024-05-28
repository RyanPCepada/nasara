<?php
include 'connection.php';

$customerID = $_POST['customer_id'];
$notificationType = $_POST['type'];

$response = [];

if ($notificationType == 'Sent feedback') {
    $sql = "
        SELECT
            CONCAT('images/', ci.image) AS 'Profile picture',
            ci.customer_ID AS 'Customer ID',
            CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS 'Full Name',
            fb.products AS 'Products',
            fb.services AS 'Services',
            fb.convenience AS 'Convenience',
            fb.rating AS 'Rating',
            fb.date AS 'Date'
        FROM tbl_customer_info AS ci
        JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
        WHERE ci.customer_ID = :customerID
        ORDER BY fb.feedback_ID DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($notificationType == 'Sent audio feedback') {
    $sqlAudios = "
        SELECT 
            CONCAT('images/', ci.image) AS 'Profile picture',
            ci.customer_ID AS 'Customer ID',
            CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS 'Full Name',
            af.audio AS 'Audio',
            af.dateAdded AS 'Date'
        FROM tbl_customer_info AS ci
        JOIN tbl_audio_feedback AS af ON ci.customer_ID = af.customer_ID
        WHERE ci.customer_ID = :customerID
        ORDER BY af.audio_ID DESC
    ";
    $stmtAudios = $conn->prepare($sqlAudios);
    $stmtAudios->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $stmtAudios->execute();
    $response = $stmtAudios->fetch(PDO::FETCH_ASSOC);
} elseif ($notificationType == 'Registered an account') {
    $sql = "
        SELECT 
            CONCAT('images/', image) AS 'Profile picture',
            customer_ID AS 'Customer ID',
            firstName AS 'Firstname',
            middleName AS 'Middlename',
            lastName AS 'Lastname',
            street AS 'Street',
            barangay AS 'Barangay',
            municipality AS 'Municipality',
            province AS 'Province',
            zipcode AS 'Zipcode',
            phoneNumber AS 'Phone Number',
            birthDate AS 'Birthdate',
            gender AS 'Gender',
            email AS 'Email',
            password AS 'Password',
            dateAdded AS 'Creation Date'
        FROM tbl_customer_info
        WHERE customer_ID = :customerID
        ORDER BY customer_ID DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);
}

echo json_encode($response);
?>