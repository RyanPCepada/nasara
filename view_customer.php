<?php
session_start();  // Start the session to access session variables

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

        // Get the customer's ID from the query parameter
        $customerID = isset($_GET['customer_ID']) ? $_GET['customer_ID'] : null;

        if ($customerID) {
            // Fetch the customer's information
            $query = $conn->prepare("SELECT * FROM tbl_customer_info WHERE customer_ID = :customerID");
            $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
            $query->execute();
            $customer = $query->fetch(PDO::FETCH_ASSOC);

            // Fetch the customer's feedbacks
            $feedbackQuery = $conn->prepare("SELECT * FROM tbl_feedback WHERE customer_ID = :customerID ORDER BY feedback_ID DESC");
            $feedbackQuery->bindParam(':customerID', $customerID, PDO::PARAM_INT);
            $feedbackQuery->execute();
            $feedbacks = $feedbackQuery->fetchAll(PDO::FETCH_ASSOC);

            // Fetch the customer's audio files
            $audioQuery = $conn->prepare("SELECT * FROM tbl_audio_feedback WHERE customer_ID = :customerID ORDER BY audio_ID DESC");
            $audioQuery->bindParam(':customerID', $customerID, PDO::PARAM_INT);
            $audioQuery->execute();
            $audioFiles = $audioQuery->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "No customer ID provided.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    // Handle the case where the admin is not logged in
    echo "You must be logged in as an admin to view this page.";
    exit();  // Exit the script
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--FOR PIE CHART-->
    <title>Nasara - Admin</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/admin/style_ad.css">

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">

        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">

        <!-- <form action="actions_admin/logoutAction_admin.php" method="post">
            <button class="btn" type="submit" id="logout" onclick="window.location.href='login_main.php'"
            >Log Out</button>
        </form> -->

        <img src="images_admin/<?php echo $adminimage; ?>" id="icon_profile" class="img-fluid zoomable-image rounded-square" onclick="to_adminacc()">
        
    </nav>


    <button type="button" class="btn btn-secondary" style="width: 40px; height: 40px; margin-top: 20px; margin-left: 105px; border-radius: 50%;"
        href="#" onclick="window.history.back();">
        <i class="fas fa-arrow-left" style="font-size: 20px;"></i>
    </button>


    <div class="container mt-5">
        <h2 style="margin-bottom: 20px; color: gray;">Customer Details</h2>
        <?php if ($customer): ?>
            <div class="card mb-3">
            <div class="card-body">
                <img src="images/<?php echo htmlspecialchars($customer['image']); ?>" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 75px;">
                <h4 class="card-title"><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['middleName'] . ' ' . $customer['lastName']); ?></h4>
                <p><strong>Customer ID:</strong> <?php echo htmlspecialchars($customer['customer_ID']); ?></p> <!-- Add this line -->
                <p><strong>Address:</strong> <?php echo htmlspecialchars($customer['street'] . ', ' . $customer['barangay'] . ', ' . $customer['municipality'] . ', ' . $customer['province'] . ', ' . $customer['zipcode']); ?></p>
                <p><strong>Birth Date:</strong> <?php echo htmlspecialchars($customer['birthDate']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($customer['gender']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($customer['phoneNumber']); ?></p>
            </div>

            </div>

            <h2 style="margin-top: 50px; color: gray;">Written Feedbacks</h2>
            <div class="scrollable-content">
                <?php
                // Initialize feedback categories
                $feedbackCategory = [
                    'Today' => [],
                    'Yesterday' => [],
                    'Older' => []
                ];

                // Categorize feedbacks based on date
                foreach ($feedbacks as $feedback) {
                    $feedbackDate = new DateTime($feedback['date']);
                    $now = new DateTime();
                    $interval = $now->diff($feedbackDate);
                    
                    if ($interval->days == 0) {
                        // Today's feedback
                        $feedbackCategory['Today'][] = $feedback;
                    } elseif ($interval->days == 1) {
                        // Yesterday's feedback
                        $feedbackCategory['Yesterday'][] = $feedback;
                    } else {
                        // Older feedback
                        $feedbackCategory['Older'][] = $feedback;
                    }
                }

                // Function to display feedbacks
                function displayFeedbacks($feedbacks, $heading, $color) {
                    // Display feedbacks
                    if (!empty($feedbacks)) {
                        // echo '<div style="background-color: ' . $color . ';">';
                        echo '<h4 style="margin-top: 20px; padding: 15px; margin-left: 12px; font-size: 20px; color: gray;">' . $heading . '</h4>';
                        foreach ($feedbacks as $feedback) {
                            echo '<div class="row" style="background-color: ' . $color . '; margin-left: 0px; margin-right: 0px; padding: 15px; border-radius: 5px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166); margin-bottom: 15px;">';
                            echo '<div class="col">';
                            echo '<p class="card-text"><strong>Opinion:</strong> ' . htmlspecialchars($feedback['products']) . '</p>';
                            echo '<p class="card-text"><strong>Suggestion:</strong> ' . htmlspecialchars($feedback['services']) . '</p>';
                            echo '<p class="card-text"><strong>Question:</strong> ' . htmlspecialchars($feedback['convenience']) . '</p>';
                            echo '<p class="card-text"><strong>Rating:</strong> ' . htmlspecialchars($feedback['rating']) . '</p>';
                            echo '<p class="card-text" style="color: blue; font-size: 15px; margin-top: 10px;">' . formatRelativeDate($feedback['date'], $heading) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<div style="background-color: ' . $color . ';">';
                        echo '<h4 style="margin-top: 20px; padding: 15px; margin-left: 12px; font-size: 20px; color: gray;">' . $heading . '</h4>';
                        echo '<p style="margin-left: 15px; font-size: 18px; color: gray;">No feedback records for ' . $heading . '.</p>';
                        echo '</div>';
                    }
                }

                // Display feedbacks
                displayFeedbacks($feedbackCategory['Today'], 'Today', '#ecffed');
                displayFeedbacks($feedbackCategory['Yesterday'], 'Yesterday', '#f1e9e9');
                displayFeedbacks($feedbackCategory['Older'], 'Older', '#ecedff');
                ?>
            </div>
        <?php else: ?>
            <p>Customer not found.</p>
        <?php endif; ?>
    </div>



    <!-- AUDIO FEEDBACKS TABLE -->
    <h2 style="margin-left: 113px; margin-top: 50px; margin-bottom: 0px; color: gray;">Audio Feedbacks</h2>
    <div class="row" style="width: 1347px;" style="position: relative; justify-content: center; background: white; margin-bottom: 0px;">
        
        <div class="scrollable-content" style="margin-left: 113px;" id="table_audio_fb">
            <?php

            // Fetch and display customer activities from tbl_activity_logs and audio records from tbl_audio_feedback
            $sqlAudios = "
            SELECT 
            CONCAT('images/', ci.image) AS 'Profile picture',
            ci.customer_ID AS 'Customer ID',
            CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS 'Full Name',
            af.audio AS 'Audio',
            af.dateAdded AS 'Date'
            FROM tbl_customer_info AS ci
            JOIN tbl_audio_feedback AS af ON ci.customer_ID = af.customer_ID
            WHERE ci.customer_ID = :CustomerID
            ORDER BY af.audio_ID DESC;
            ";

            $stmtAudios = $conn->prepare($sqlAudios);
            $stmtAudios->bindParam(':CustomerID', $customerID, PDO::PARAM_INT);
            $stmtAudios->execute();
            $audios = $stmtAudios->fetchAll();

            $todayAudios = [];
            $yesterdayAudios = [];
            $olderAudios = [];

            $now = new DateTime();
            $yesterday = (clone $now)->modify('-1 day');

            foreach ($audios as $audio) {
                $audioDate = new DateTime($audio['Date']);

                if ($audioDate->format('Y-m-d') == $now->format('Y-m-d')) {
                    $todayAudios[] = $audio;
                } elseif ($audioDate->format('Y-m-d') == $yesterday->format('Y-m-d')) {
                    $yesterdayAudios[] = $audio;
                } else {
                    $olderAudios[] = $audio;
                }
            }

            function displayAudios($audios, $heading, $marginTop) {
                echo '<h4 style="margin-top: ' . $marginTop . '; padding: 15px; margin-left: 12px; font-size: 20px; color: gray;">' . $heading . '</h4>';

                if (empty($audios)) {
                    echo '<p style="margin-left: 15px; font-size: 18px; color: gray;">No audio records ' . strtolower($heading) . '.</p>';
                } else {
                    foreach ($audios as $audio) {
                        echo '<div class="row" style="margin-left: 15px; margin-top: 10px; padding-bottom: 10px;">';

                        echo '<div class="col-auto">';
                        echo '<img src="' . htmlspecialchars($audio['Profile picture']) . '" alt="Profile picture" style="width: 80px; height: 80px; border: solid 0px lightblue; border-radius: 50%; background-color: white;">';
                        echo '</div>';

                        echo '<div class="col">';
                        echo '<p style="margin-top: 10px; font-weight: bold;">' . htmlspecialchars($audio['Full Name']) . '</p>';
                        echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($audio['Date'], $heading) . '</p>';
                        echo '</div>';

                        echo '<div class="col-auto">';
                        echo '<audio controls style="width: 500px; margin-right: 50px; margin-top: 12px;">';
                        echo '<source src="http://localhost/nasara/audios/' . htmlspecialchars($audio['Audio']) . '" type="audio/' . pathinfo($audio['Audio'], PATHINFO_EXTENSION) . '">';
                        echo 'Your browser does not support the audio element.';
                        echo '</audio>';
                        echo '</div>';

                        echo '</div>';
                    }
                }
            }

            // Function to format relative date and time
            function formatRelativeDate($date, $category) {
                $formattedDate = new DateTime($date);
                $now = new DateTime();
                $interval = $now->diff($formattedDate);

                if ($category === 'Today') {
                    return 'Today @ ' . $formattedDate->format('h:i A'); // 12-hour format with AM/PM
                } elseif ($category === 'Yesterday') {
                    return 'Yesterday @ ' . $formattedDate->format('h:i A');
                } else {
                    if ($interval->days == 1) {
                        return '1 day ago @ ' . $formattedDate->format('h:i A');
                    } elseif ($interval->days == 7) {
                        return '1 week ago @ ' . $formattedDate->format('h:i A');
                    } elseif ($interval->days > 7) {
                        return $formattedDate->format('F j, Y @ h:i A');
                    } else {
                        return $interval->days . ' days ago @ ' . $formattedDate->format('h:i A');
                    }
                }
            }
            ?>

            <div class="scrollable-content">
                <div class="" style="position: relative; width: 98%;"> <!--REASON WHY AUDIO FEEDBACK TABLE SCROOLBAR BELOW-->
                    <?php
                    // Display "Today" audio records with background color #ecffed
                    echo '<div style="background-color: #ecffed;">';
                    displayAudios($todayAudios, 'Today', '20px');
                    echo '</div>';

                    // Display "Yesterday" audio records with background color #f1e9e9
                    echo '<div style="background-color: #f1e9e9;">';
                    displayAudios($yesterdayAudios, 'Yesterday', '20px');
                    echo '</div>';

                    // Display "Older" audio records with background color #ecedff
                    echo '<div style="background-color: #ecedff;">';
                    displayAudios($olderAudios, 'Older', '20px');
                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END AUDIO FEEDBACKS TABLE -->


    <div class="row" style="margin: 50px;"></div>
</body>
</html>



<script>
    function to_adminfeedbacks() {
        window.location.href = 'admin_feedbacks.php';
    }
</script>
