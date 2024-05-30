<?php
include 'connection.php';

// THIS FILE IS EXCLUSIVE ONLY FOR ADMIN NOTIFICATIONS FUNCTION

$customerID = $_POST['customer_id'];
$notificationType = $_POST['type'];

$response = [];

// Fetch the top customer data
$sqlTopCustomer = "SELECT ci.customer_ID FROM tbl_customer_info ci
                    LEFT JOIN tbl_feedback fb ON ci.customer_ID = fb.customer_ID
                    LEFT JOIN tbl_audio_feedback af ON ci.customer_ID = af.customer_ID
                    GROUP BY ci.customer_ID
                    ORDER BY (COUNT(fb.feedback_ID) + COUNT(af.audio_ID)) DESC
                    LIMIT 1";

$stmtTopCustomer = $conn->prepare($sqlTopCustomer);
$stmtTopCustomer->execute();
$topCustomer = $stmtTopCustomer->fetch(PDO::FETCH_ASSOC);

if ($notificationType == 'Sent feedback') {
    // Fetch the feedback details
    $feedbackID = $_POST['feedback_ID'];
    $sql = "
        SELECT
            CONCAT('images/', ci.image) AS 'Profile picture',
            ci.customer_ID AS 'Customer ID',
            CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS 'Full Name',
            fb.feedback_ID,
            fb.products AS 'Products',
            fb.services AS 'Services',
            fb.convenience AS 'Convenience',
            fb.rating AS 'Rating',
            fb.date AS 'Date'
        FROM tbl_customer_info AS ci
        JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
        WHERE fb.feedback_ID = :feedbackID
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':feedbackID', $feedbackID, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);

    // Add the top customer flag to the response
    $response['isTopCustomer'] = ($customerID == $topCustomer['customer_ID']);
} elseif ($notificationType == 'Sent audio feedback') {
    // Fetch the audio feedback details
    $audioID = $_POST['audio_ID'];
    $sqlAudios = "
        SELECT 
            CONCAT('images/', ci.image) AS 'Profile picture',
            ci.customer_ID AS 'Customer ID',
            CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS 'Full Name',
            af.audio AS 'Audio',
            af.dateAdded AS 'Date'
        FROM tbl_customer_info AS ci
        JOIN tbl_audio_feedback AS af ON ci.customer_ID = af.customer_ID
        WHERE af.audio_ID = :audioID
    ";
    $stmtAudios = $conn->prepare($sqlAudios);
    $stmtAudios->bindParam(':audioID', $audioID, PDO::PARAM_INT);
    $stmtAudios->execute();
    $response = $stmtAudios->fetch(PDO::FETCH_ASSOC);

    // Add the top customer flag to the response
    $response['isTopCustomer'] = ($customerID == $topCustomer['customer_ID']);
} elseif ($notificationType == 'Registered an account') {
    // Fetch the account registration details
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
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);

    // Add the top customer flag to the response
    $response['isTopCustomer'] = ($customerID == $topCustomer['customer_ID']);
}

echo json_encode($response);
?>
