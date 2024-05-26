<?php
// Include your database connection file
include 'connection.php';

// Get the notification data from the request
$notificationData = json_decode($_GET['notificationData'], true);

// Fetch details based on the notification type
$notificationType = $notificationData['type'];
$customerId = $notificationData['customer_id'];

// Fetch customer's image
$sqlImage = "SELECT image FROM tbl_customer_info WHERE customer_ID = :customerId";
$stmtImage = $conn->prepare($sqlImage);
$stmtImage->bindParam(':customerId', $customerId);
$stmtImage->execute();
$imageData = $stmtImage->fetch(PDO::FETCH_ASSOC);
$imagePath = 'images/' . $imageData['image']; // Prepend base path

// Fetch customer's full name
$sqlFullName = "SELECT firstName, middleName, lastName FROM tbl_customer_info WHERE customer_ID = :customerId";
$stmtFullName = $conn->prepare($sqlFullName);
$stmtFullName->bindParam(':customerId', $customerId);
$stmtFullName->execute();
$customerFullName = $stmtFullName->fetch(PDO::FETCH_ASSOC);
$fullName = $customerFullName['firstName'] . ' ' . $customerFullName['middleName'] . ' ' . $customerFullName['lastName'];

// Depending on the notification type, fetch relevant details from the database
if ($notificationType === 'Sent feedback') {
    // Fetch feedback details for the customer from tbl_feedback
    $sqlFeedback = "SELECT * FROM tbl_feedback WHERE customer_ID = :customerId";
    $stmtFeedback = $conn->prepare($sqlFeedback);
    $stmtFeedback->bindParam(':customerId', $customerId);
    $stmtFeedback->execute();
    $feedback = $stmtFeedback->fetch(PDO::FETCH_ASSOC);

    echo '<p><strong>WRITTEN FEEDBACK</strong></p>';
    // Display customer's image
    echo '<img src="' . $imagePath . '" style="width: 100px; height: 100px; border-radius: 50%;">';
    
    // Display the feedback details
    echo '<p><strong>Full Name:</strong> ' . $fullName . '</p>';
    echo '<p><strong>Products:</strong> ' . $feedback['products'] . '</p>';
    echo '<p><strong>Services:</strong> ' . $feedback['services'] . '</p>';
    echo '<p><strong>Convenience:</strong> ' . $feedback['convenience'] . '</p>';
    echo '<p><strong>Rating:</strong> ' . $feedback['rating'] . '</p>';
    echo '<p><strong>Date:</strong> ' . $feedback['date'] . '</p>';

    // Add the "View Customer's Information" button
    echo '<button class="btn btn-primary btn-block" onclick="viewCustomerInfo()">View Customer\'s Information</button>';

} elseif ($notificationType === 'Sent audio feedback') {
    // Fetch audio feedback details for the customer from tbl_audio_feedback
    $sqlAudioFeedback = "SELECT * FROM tbl_audio_feedback WHERE customer_ID = :customerId";
    $stmtAudioFeedback = $conn->prepare($sqlAudioFeedback);
    $stmtAudioFeedback->bindParam(':customerId', $customerId);
    $stmtAudioFeedback->execute();
    $audioFeedback = $stmtAudioFeedback->fetch(PDO::FETCH_ASSOC);

    echo '<p><strong>AUDIO FEEDBACK</strong></p>';
    // Display customer's image
    echo '<img src="' . $imagePath . '" style="width: 100px; height: 100px; border-radius: 50%;">';
    
    // Display the audio feedback details within the modal
    echo '<p><strong>Full Name:</strong> ' . $fullName . '</p>';
    echo '<p><strong>Audio:</strong> <audio controls><source src="audios/' . $audioFeedback['audio'] . '" type="audio/mpeg"></audio></p>';
    echo '<p><strong>Date Added:</strong> ' . $audioFeedback['dateAdded'] . '</p>';

    // Add the "View Customer's Information" button
    echo '<button class="btn btn-primary btn-block" onclick="viewCustomerInfo()">View Customer\'s Information</button>';

} elseif ($notificationType === 'Registered an account') {
    // Fetch additional details for the customer from tbl_customer_info
    $sqlCustomerInfo = "SELECT street, barangay, municipality, province, zipcode, birthDate, gender, email, phoneNumber 
                        FROM tbl_customer_info WHERE customer_ID = :customerId";
    $stmtCustomerInfo = $conn->prepare($sqlCustomerInfo);
    $stmtCustomerInfo->bindParam(':customerId', $customerId);
    $stmtCustomerInfo->execute();
    $customerInfo = $stmtCustomerInfo->fetch(PDO::FETCH_ASSOC);

    echo '<p><strong>REGISTRATION</strong></p>';
    // Display customer's image
    echo '<img src="' . $imagePath . '" style="width: 100px; height: 100px; border-radius: 50%;">';

    // Display additional details
    echo '<p><strong>Full Name:</strong> ' . $fullName . '</p>';
    echo '<p><strong>Address:</strong> ' . ($customerInfo['street'] ?? '') . ', ' . ($customerInfo['barangay'] ?? '') . ', ' . ($customerInfo['municipality'] ?? '') . ', ' . ($customerInfo['province'] ?? '') . ', ' . ($customerInfo['zipcode'] ?? '') . '</p>';
    echo '<p><strong>Birth Date:</strong> ' . ($customerInfo['birthDate'] ?? '') . '</p>';
    echo '<p><strong>Gender:</strong> ' . ($customerInfo['gender'] ?? '') . '</p>';
    echo '<p><strong>Email:</strong> ' . ($customerInfo['email'] ?? '') . '</p>';
    echo '<p><strong>Phone Number:</strong> ' . ($customerInfo['phoneNumber'] ?? '') . '</p>';
    
    // Add the "View Customer's Information" button
    echo '<button class="btn btn-primary btn-block" onclick="viewCustomerInfo()">View Customer\'s Information</button>';
}

// JavaScript function to redirect to view_customer.php with customer ID parameter
echo '<script>
        function viewCustomerInfo() {
            window.location.href = "view_customer.php?customer_ID=' . $customerId . '";
        }
      </script>';
?>
