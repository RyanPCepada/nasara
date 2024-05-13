<?php

session_start();

if (isset($_SESSION['adminID'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cfms";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $adminID = $_SESSION['adminID'];

        // Check if the user submitted a new profile image
        if (isset($_FILES['image']) && $_FILES['image']['name']) {
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];

            // Add image validation logic here
            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
            $imageExtension = strtolower($imageExtension);
            
            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "Error: Invalid image extension. Only JPG, JPEG, and PNG are allowed.";
            } elseif ($imageSize > 1200000) {
                echo "Error: Image size is too large (max 1.2MB).";
            } else {
                // Generate a unique file name for the new image
                $newImageName = $adminID . '_' . date("Y.m.d") . '_' . date("h.i.sa") . '.' . $imageExtension;

                // Save the image to your server
                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/DevBugs/images/' . $newImageName;
                move_uploaded_file($tmpName, $uploadPath);

                // Update the admin's profile picture in tbl_admin
                $updateProfilePic = $conn->prepare("UPDATE tbl_admin SET image = :image WHERE admin_ID = :adminID");
                $updateProfilePic->bindParam(':image', $newImageName);
                $updateProfilePic->bindParam(':adminID', $adminID);
                $updateProfilePic->execute();
            }
        }

        // Insert an activity log in tbl_activity_logs
        // $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, admin_ID) VALUES (?, ?)');
        // $insertActivity->execute(["Changed Profile Picture", $adminID]);

        // Redirect to the user's profile page
        echo '<script>alert("Profile Picture Successfully Changed!");';
        echo 'window.location.href = "http://localhost/DevBugs/admin_account.php";</script>';


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
} else {
    echo "You must be logged in to upload a profile picture.";
    exit();
}
?>



