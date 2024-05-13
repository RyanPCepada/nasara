<?php
session_start();  // Start the session to access session variables

// Check if the user is logged in (you can adjust this based on your session variable)
if (isset($_SESSION['adminID'])) {
    // Replace these database connection details with your own
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cfms";

    try {
        // Create a PDO connection to your database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get the customer's first name and last name from the database based on the customer ID
        $customerID = $_SESSION['adminID'];
        $query = $conn->prepare("SELECT firstName, middleName, lastName, street, barangay, municipality, province, zipcode, birthdate, gender,
            phoneNumber, password FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();




        //FETCH ACTIVITY LOGS FOR HISTORY LIST
        // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        $sql1 = "SELECT activity FROM tbl_activity_logs WHERE customer_ID = $customerID ORDER BY dateAdded DESC";
        $sql2 = "SELECT dateAdded FROM tbl_activity_logs WHERE customer_ID = $customerID ORDER BY dateAdded DESC";
        // Prepare and execute the query
        $stmt1 = $conn->prepare($sql1);
        $stmt2 = $conn->prepare($sql2);
        $stmt1->execute();
        $stmt2->execute();

        // Fetch all the "firstName" values into an array
        $activities = $stmt1->fetchAll(PDO::FETCH_COLUMN);
        $dates = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        //END FETCH ACTIVITY LOGS FOR HISTORY LIST





        // Fetch the user's information
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Check if data was found in the database
        if ($user !== false) {
            $firstName = $user['firstName'];
            $middleName = $user['middleName'];
            $lastName = $user['lastName'];
            $street = $user['street'];
            $barangay = $user['barangay'];
            $municipality = $user['municipality'];
            $province = $user['province'];
            $zipcode = $user['zipcode'];
            // $day = $user['day'];
            // $month = $user['month'];
            // $year = $user['year'];
            $birthDate = $user['birthdate'];
            $gender = $user['gender'];
            $phoneNumber = $user['phoneNumber'];
            $password = $user['password'];
            // $image = $user['image'];
        } else {
            $firstName = '';
            $middleName = '';
            $lastName = '';
            $street = '';
            $barangay = '';
            $municipality = '';
            $province = '';
            $zipcode = '';
            // $day = '';
            // $month = '';
            // $year = '';
            $birthDate = '';
            $gender = '';
            $phoneNumber = '';
            $password = '';
            // $image = '';
        }



        // Get admin information based on adminID from the session
        $adminID = $_SESSION['adminID'];
        $adminQuery = $conn->prepare("SELECT userName, password, image FROM tbl_admin WHERE admin_ID = :adminID");
        $adminQuery->bindParam(':adminID', $adminID, PDO::PARAM_INT);
        $adminQuery->execute();

        // Fetch the admin's information
        $admin = $adminQuery->fetch(PDO::FETCH_ASSOC);

        // Check if data was found in the database
        if ($admin !== false) {
            // Assign the username to $userName
            $userName = $admin['userName'];
            $adminimage = $admin['image'];
            $password = $admin['password'];
        } else {
            $userName = '';
            $adminimage = '';
            $password = '';
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
} else {
    // Handle the case where the user is not logged in
    echo "You must be logged in to view this page.";
    exit();  // Exit the script
}
?>









<?php
// Step 1: Connect to the database (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cfms";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/boxicons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>DevBugs</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/admin_account/style_adacc.css">

    <!-- PARALLAX -->
    <div class="container-fluid">
        <div class="parallax">


            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="position: absolute; margin-top: -655px; height: 110px;">

                    <div class="container-fluid col-9">
                        <div class="" style="position: absolute; width: 100px; height: 100px;">
                            <img src="pages/home/LOGO.png" class="img-fluid" alt="">
                        </div> 
                        
                        <h1 style="position: absolute; margin-left: 100px; margin-top: -20px; color: lightblue;">Octawiz-Devbugs</h1>
                        <h1 class="tit" style="position: absolute; margin-top: 50px; margin-left: 100px; color: smokewhite; font-size: 20px;"
                        >Customer Feedback Management System</h1>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        
                        <!-- <form style="margin-left: 450px;">
                            <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" id="search">
                        </form> -->
                    </div>
                    <div class="container-fluid col-3">

                        <button type="button" class="btn btn-secondary position-relative" id="openAdminNotifModalBtn" data-bs-toggle="modal" data-bs-target="#modal_adminmess"
                            style="margin-right: 20px; margin-left: -40px;"">
                            Messages
                            <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <!-- 0 -->
                                
                                <?php
                                    $sqlMessage = "SELECT COUNT(message_ID) AS messageCount FROM tbl_message";  //WHERE DATE(date) = CURDATE()
                                    $stmtMessage = $conn->prepare($sqlMessage);
                                    $stmtMessage->execute();
                                    $messageCount = $stmtMessage->fetchColumn();
                                    echo $messageCount;
                                ?>

                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>


                        <!-- ADMIN MESSAGES MODAL -- FOR VIEWING ADMIN MESSAGES -->
                        <div class="modal fade" id="modal_adminmess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                            style="margin-left: 350px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Messages</h3>
                                        <img src="pages/admin/GIF_MESSAGES.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                                    </div>

                                    <div class="scrollable-content" id="messageContent" style="height: 450px; padding: 20px; overflow-y: auto; color: black;">

                                        <div class="">
                                            <?php
                                            // Fetch messages with concatenated first and last names as Sender
                                            $sqlMessage = "SELECT message_ID AS Message_ID, CONCAT(firstName, ' ', lastName) AS Sender, message AS Message, date AS Date,
                                                        email AS Email, contactNumber AS Contact, customer_ID AS Customer_ID FROM tbl_message ORDER BY date DESC";
                                            $stmtMessage = $conn->prepare($sqlMessage);
                                            $stmtMessage->execute();
                                            $messages = $stmtMessage->fetchAll(PDO::FETCH_ASSOC);
                                            ?>

                                            <?php
                                            // Output messages in the alternative design
                                            foreach ($messages as $message) {
                                                $messageDate = new DateTime($message["Date"]);
                                                $currentDate = new DateTime();

                                                $interval = $currentDate->diff($messageDate);
                                                $formattedDate = '';

                                                if ($interval->d == 0) {
                                                    $formattedDate = 'Today';
                                                } elseif ($interval->d == 1) {
                                                    $formattedDate = 'Yesterday';
                                                } else {
                                                    $formattedDate = $interval->d . ' days ago';
                                                }

                                                // Append time if it's not today
                                                if ($interval->d > 0 || $interval->h > 0 || $interval->i > 0) {
                                                    $formattedDate .= ' @ ' . $messageDate->format('h:i A');
                                                }

                                                ?>
                                                <div class="message-container">
                                                    <div class="row" style="width: 450px; background-color: #ecffed; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                                        border-radius: 15px; margin-bottom: 10px;  margin-left: -5px;">
                                                        <strong class="message-sender" style="margin-top: 10px;"><?php echo $message["Sender"]; ?></strong>
                                                        <p class="message-content" style="font-size: 20px;"><?php echo $message["Message"]; ?></p>
                                                    </div>

                                                    <p class="message-date" style="margin-bottom: 0px; color: blue;"><?php echo $formattedDate; ?></p>
                                                    <p class="message-email text-muted" style="margin-bottom: 0px;">Email: <?php echo $message["Email"]; ?></p>
                                                    <p class="message-contactnum text-muted">Contact #: <?php echo $message["Contact"]; ?></p>
                                                    <p class="visually-hidden">Message ID: <?php echo $message["Message_ID"]; ?></p>
                                                    <p class="visually-hidden">Customer ID: <?php echo $message["Customer_ID"]; ?></p>

                                                    <button type="button" class="btn btn-primary reply-btn" id="openAdminReplyModalBtn_<?php echo $message["Customer_ID"]; ?>" data-bs-toggle="modal" style="width: 150px;"
                                                    data-bs-target="#modal_adminreply" onclick="openmodal_adminreply('<?php echo $message["Message_ID"]; ?>', '<?php echo $message["Customer_ID"]; ?>', '<?php echo $message["Sender"]; ?>')"
                                                    >Reply</button>

                                                    <hr>
                                                </div>
                                            <?php
                                            }

                                            // Check if no messages found
                                            if (empty($messages)) {
                                                echo "<p>No messages found</p>";
                                            }
                                            ?>
                                        </div>

                                    </div>

                                    <div class="modal-footer" style="height: 70px;">
                                        <button type="button" class="btn btn-secondary float-end" style="margin-top: 5px; margin-bottom: 15px; margin-right: 5px;" id="adminmess_closeModalBtn" data-bs-dismiss="modal"
                                        >Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        function openmodal_adminmess() {
                            $('#modal_adminmess').modal('show');
                        }
                        </script>
                        <!-- END ADMIN MESSAGES MODAL -- FOR VIEWING ADMIN MESSAGES -->




                        <!-- ADMIN REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->
                        <div class="modal fade" id="modal_adminreply" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                            style="margin-left: 0px; margin-top: 150px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="row" id="messageContent" style="height: 230px; padding: 20px; overflow-y: auto; color: black;">
                                        <!-- Previous messages here -->

                                        <!-- Reply form -->
                                        <form action="actions_admin/admin_reply.php" method="post">
                                            
                                            <input type="hidden" name="message_ID" value="<?php echo $message['Message_ID']; ?>">
                                            <input type="hidden" name="customer_ID" value="<?php echo $message['Customer_ID']; ?>">
                                            <input type="hidden" id="customer_id_input" name="customer_id" value="">

                                            <div class="form-group">
                                                <label class="text-muted" for="replyTextArea" style="margin-bottom: 10px;">Replying to: <strong class="message-sender text-unmuted"><?php echo $message["Sender"]; ?></strong></label>
                                                <textarea class="form-control" id="replyTextArea" name="admin_reply" rows="3" required></textarea>
                                            </div>

                                            <div >
                                                <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Send Reply</button>
                                                <button type="button" class="btn btn-secondary float-end" style="margin-top: 25px; margin-bottom: 0px; margin-right: 0px;" id="adminmess_closeModalBtn" data-bs-dismiss="modal"
                                                >Close</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            function openmodal_adminreply(messageId, customerId, senderName) {
                                // Set the message ID, customer ID, and sender name in the reply modal
                                $('#modal_adminreply').find('[name="message_ID"]').val(messageId);
                                $('#modal_adminreply').find('[name="customer_ID"]').val(customerId);
                                $('#modal_adminreply').find('.message-sender').text(senderName);

                                // Show the reply modal using Bootstrap's modal method
                                $('#modal_adminreply').modal('show');
                            }
                        </script>
                        <!-- ADMIN REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->



                        <button type="button" class="btn btn-secondary position-relative" id="openAdminNotifModalBtn" data-bs-toggle="modal" data-bs-target="#modal_adminnotif" style="margin-right: 25px;">
                            Notifications
                            <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php
                                // Fetch the count of new feedbacks for today
                                $sqlFeedback = "SELECT COUNT(feedback_ID) AS feedbackCount FROM tbl_feedback"; // WHERE DATE(date) = CURDATE()
                                $stmtFeedback = $conn->prepare($sqlFeedback);
                                $stmtFeedback->execute();
                                $feedbackCount = $stmtFeedback->fetchColumn();

                                // Fetch the count of new customers for today
                                $sqlCustomers = "SELECT COUNT(customer_ID) AS customerCount FROM tbl_customer_info"; // WHERE DATE(dateAdded) = CURDATE()
                                $stmtCustomers = $conn->prepare($sqlCustomers);
                                $stmtCustomers->execute();
                                $customerCount = $stmtCustomers->fetchColumn();

                                // Calculate and display the combined count of feedbacks and new customers
                                $totalNotifications = $feedbackCount + $customerCount;
                                echo $totalNotifications;
                                ?>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>

                        <!-- ADMIN NOTIFICATIONS MODAL -- FOR VIEWING ADMIN NOTIFICATIONS -->
                        <div class="modal fade" id="modal_adminnotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-left: 350px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Notifications</h3>
                                        <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                                    </div>

                                    <div class="scrollable-content" id="inputfields" style="height: 500px; overflow-y: auto; color: black; background: lightgray;">
                                        <div class="" style="position: relative;">
                                            <?php
                                            // Fetch and display customer registrations and feedback submissions
                                            $sqlNotifications = "
                                                (SELECT CONCAT(firstName, ' ', lastName) AS name, dateAdded AS date, 'registration' AS type
                                                FROM tbl_customer_info)
                                                UNION
                                                (SELECT CONCAT(firstName, ' ', lastName) AS name, date, 'feedback' AS type
                                                FROM tbl_customer_info ci
                                                JOIN tbl_feedback f ON ci.customer_id = f.customer_id)
                                                ORDER BY date DESC
                                            ";

                                            $stmtNotifications = $conn->prepare($sqlNotifications);
                                            $stmtNotifications->execute();
                                            $notifications = $stmtNotifications->fetchAll();

                                            foreach ($notifications as $notification) {
                                                echo '<div class="row" style="background-color: white; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                                    border-radius: 5px; font-size: 20px; width: 450px; margin-left: 15px; margin-top: 20px;">'; //#ecffed

                                                if ($notification['type'] == 'registration') {
                                                    // echo '<img src="images/<?php echo $image; >" class="img-fluid zoomable-image rounded-square" style="position: absolute; width: 50px; border-radius: 25px;">';
                                                    echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has registered an account.</p>';
                                                } elseif ($notification['type'] == 'feedback') {
                                                    echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has submitted a feedback.</p>';
                                                }

                                                // Display relative date and time below
                                                echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['date']) . '</p>';

                                                echo '</div>';
                                            }

                                            // Function to format relative date and time
                                            function formatRelativeDate($date)
                                            {
                                                $now = new DateTime();
                                                $formattedDate = new DateTime($date);
                                                $interval = $now->diff($formattedDate);

                                                if ($interval->days == 0) {
                                                    if ($interval->h == 0) {
                                                        return 'Today';
                                                    } else {
                                                        return 'Today @ ' . $formattedDate->format('h:i A'); // 12-hour format with AM/PM
                                                    }
                                                } elseif ($interval->days == 1) {
                                                    return 'Yesterday @ ' . $formattedDate->format('h:i A');
                                                } else {
                                                    return $interval->days . ' days ago @ ' . $formattedDate->format('h:i A');
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer" style="height: 70px;">
                                        <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px; margin-bottom: 15px; margin-right: 5px;" id="adminnotif_closeModalBtn" data-bs-dismiss="modal"
                                        >Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function openmodal_adminnotif() {
                                $('#modal_adminnotif').modal('show');
                            }
                        </script>
                        <!-- END ADMIN NOTIFICATIONS MODAL -- FOR VIEWING ADMIN NOTIFICATIONS -->









                        

                        <img src="images/<?php echo $adminimage; ?>" class="img-fluid rounded-square" onclick="to_adminacc()" style="width: 30px; height: 30px; border-radius: 15px;">

                        <div class = " m-2 text-light" >   
                            <b class = "bg-transparent "  id="accountLink" onclick="to_adminacc()" style=" cursor: pointer;"> <img src="navigation/user.png" alt=""
                            >Account</b>
                        </div>

                    </div>
                    </nav>
            </div>




            <!-- <hr> -->




            <div class="accbg">
                <div class="container">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-4 bg-transparent">
                            <div class="col-2 ">
                                <!-- <button class="text-primary" style="width: 200px;">Profile</button> -->
                                <button type="button" class="btn btn-primary" id="todashboardbtn" style="width: 200px; height: 44px; margin-top: 30px;" onclick="window.location.href='admin_main.php';">
                                    Dashboard
                                </button>
                            </div>
                            <div class="col-2 ">
                                <p> </p>
                            </div>
                            <div class="col-2 ">
                                <button type="button" class="btn btn-primary" id="openProfileModalBtn" data-bs-toggle="modal" data-bs-target="#modal_profile"
                                    style="width: 200px; height: 44px; margin-top: 0px">
                                    Profile
                                </button>
                            </div>
                            <div class="col-2 ">
                                <p> </p>
                            </div>
                            <div class="col-2 ">
                                <button type="button" class="btn btn-primary" id="openSettingsModalBtn" data-bs-toggle="modal" data-bs-target="#modal_settings"
                                    style="width: 200px; height: 44px;">
                                    Settings
                                </button>
                            </div>
                            <div class="col-2 ">
                                <p> </p>
                            </div>
                            <div class="col-2 text-danger">
                                <form action="actions_admin/logoutAction_admin.php" method="post">
                                    <style>
                                        .blue-button {
                                            background-color: black;
                                            color: white;
                                            height: 44px;
                                            padding: 10px 20px;
                                            border: none;
                                            border-radius: 5px;
                                        }
                                    </style>

                                    <button class="btn btn-primary"  style="width: 200px; height: 44px;" type="submit" id="logout" onclick="window.location.href='admin_login.php'"
                                    >Log Out</button>

                                </form>

                            </div>
                            <div class="col-2 ">
                                <p> </p>
                            </div>
                        </div>
                        <div class="col-8 bg-transparent">
                            <div class="row">
                                <div class="col-4">
                                    <div class="m-2" style="width: 80%; position: relative;">
                                        <?php
                                            $sql = "SELECT image FROM tbl_admin WHERE admin_ID = :adminID";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':adminID', $adminID, PDO::PARAM_INT);
                                            $stmt->execute();

                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $adminimage = $result['image'];
                                        ?>

                                        <img src="images/<?php echo $adminimage; ?>" class="img-fluid zoomable-image rounded-square" style="width: 2in; height: 2in;">

                                        <i class="fa fa-camera" onclick="openChangeProfilePicModal()"></i>
                                        
                                    </div>
                                </div>



                                <div class="col-8">
                                    <h1 class="" style="color: lightblue; width: 700px; font-size: 90px; margin-left: -30px; margin-top: 50px;">
                                        <?php echo $userName; ?>
                                    </h1>
                                    <!-- <p class="text-light" name="bio" style="width: 300px; margin-left: -30px;">"Trust the Process, Everything takes Time."</p> -->
                                </div>

                                


                            </div>
                            <div class="row" style="margin-left: 20px; margin-top: 50px;">
                                <!-- <div class="col text-light">
                                    <h3 class="text-light">Hobbies:</h3>
                                    <hr>
                                    <p name="hobby1">Hobby 1</p>
                                    <p name="hobby2">Hobby 2</p>
                                    <p name="hobby3">Hobby 3</p>
                                    <p name="hobby4">Hobby 4</p>
                                </div>
                                <div class="col text-light">
                                    <h3 class="text-light">Favorites:</h3>
                                    <hr>
                                    <p name="favorite1">Favorite 1</p>
                                    <p name="favorite2">Favorite 2</p>
                                    <p name="favorite3">Favorite 3</p>
                                    <p name="favorite4">Favorite 4</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            
        </div>
    </div>
    <!-- END PARALLAX -->


    

    
    

    <!-- PROFILE MODAL -- FOR EDITING PROFILE -->
    <div class="modal fade" id="modal_profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Profile</h5>
                    <img src="pages/account/GIF_PROFILE.gif" style="width: 1.4in; height: .8in; margin-left: 0px;" id="profile_gif">
                    <!-- <img  src="pages/account/profpic.png"> -->
                </div>

                <div class="modal-body">

                    <form id="editprofile_form" method="POST" action="actions_admin/edit_profile_admin.php">
                        <div class="input" id="inputfields" style="height: 130px;">
                            <p class="sub_title_2" id="sub_title_name">Username</p>
                            <input type="text" placeholder="Username" class="username" name="username" id="p_row1" value="<?php echo $userName; ?>"/>
                            
                        </div>
                        
                            <button type="submit" class="submit" name="submit" id="prof_modalsave">Save</button>
                            <button type="button" class="btn btn-secondary" id="prof_closeModalBtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button id="closeModalBtn" data-bs-dismiss="modal">Back</button> -->
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>
    <!-- END PROFILE MODAL -- FOR EDITING PROFILE -->
    




    <!-- PROFILE PICTURE MODAL -- FOR CHANGING PROFILE PICTURE -->
    <div class="modal fade" id="changeProfilePicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Profile Picture</h5>
                </div>
                <div class="modal-body">
                    <form class="form" id="form" action="actions_admin/update_profile_admin.php" enctype="multipart/form-data" method="post">
                        <div class="upload">
                            <?php
                                $sql = "SELECT image FROM tbl_admin WHERE admin_ID = :adminID";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':adminID', $adminID, PDO::PARAM_INT);
                                $stmt->execute();

                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $image = $result['image'];
                            ?>
                            <img src="images/<?php echo $image; ?>" id="selectedImage" style="width: 2in; height: 2in; margin-bottom: 20px;">
                            <div class="round">
                                <input type="hidden" name="id" value="<?php echo $adminID; ?>">
                                <input type="hidden" name="name" value="<?php echo $userName; ?>">
                                <input type="file" class="image" name="image" id="image" accept=".jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submit" id="saveProfilePic">Save</button>
                            <button type="button" class="btn btn-secondary" id="profpic_closeModalBtn" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PROFILE PICTURE MODAL -- FOR CHANGING PROFILE PICTURE -->

    <!-- JavaScript code to open the modal -->
    <script type="text/javascript">
        function openChangeProfilePicModal() {
            $('#changeProfilePicModal').modal('show');
        }
    </script>


    <!-- TO DISPLAY THE NEW CHOSEN PICTURE FROM THE COMPUTER -->
    <script>
        document.getElementById("image").addEventListener("change", function() {
            const selectedFile = this.files[0];
            if (selectedFile) {
                const selectedImage = document.getElementById("selectedImage");
                const objectURL = URL.createObjectURL(selectedFile);
                selectedImage.src = objectURL;
            } else {
                // You can handle the case when no file is selected
            }
        });
    </script>


    <!--SCRIPT FROM DAVID -- NOT FOUND BUT STORED IN DATABASE-->
    <script type="text/javascript">
        function openChangeProfilePicModal() {
            $('#changeProfilePicModal').modal('show');
        }
        document.getElementById("image").onchange = function(){
            document.getElementById("form").submit();
        };
    </script>



    <!-- BACKGROUND INFORMATION MODAL -- FOR EDITING BACKGROUND INFORMATION -->
    <!-- <div class="modal fade" id="modal_bginfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Background Information</h5>
                    <img src="pages/account/GIF_BGINFO.gif" style="width: 1.5in; height: 1in; margin-right: -15px;" id="bginfo_gif">
                </div>
                <div class="modal-body">

                    <form id="background_information_form" method="POST">
                        <div class="input" id="inputfields" style="height: 500px;">
                            <h id="bg_hobbies">Bio</h>
                            <input type="text" class="hobbies" name="hobbies" id="bg_row1"/>

                            <h id="bg_hobbies">Hobbies</h>
                            <input type="text" class="hobbies" name="hobbies" id="bg_row2" />
                            <input type="text" class="hobbies" name="hobbies" id="bg_row3" />
                            <input type="text" class="hobbies" name="hobbies" id="bg_row4"/>
                            <input type="text" class="hobbies" name="hobbies" id="bg_row5" />
                            
                            <h id="bg_favorites">Favorites</h>
                            <input type="text" class="favorites" name="favorites" id="bg_row6"/>
                            <input type="text" class="favorites" name="favorites" id="bg_row7" />
                            <input type="text" class="favorites" name="favorites" id="bg_row8" />
                            <input type="text" class="favorites" name="favorites" id="bg_row9"/>
                                
                        </div>
                            <button type="submit" class="submit" name="submit" id="bg_modalsave">Save</button>
                            <button type="button" class="btn btn-secondary" id="bg_closeModalBtn" data-bs-dismiss="modal">Close</button>                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div> -->
    <!-- END BACKGROUND INFORMATION MODAL -- FOR EDITING BACKGROUND INFORMATION -->

    
    <!-- SETTINGS MODAL -- FOR EDITING SETTINGS -->
    <div class="modal fade custom-fade" id="modal_settings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Settings</h5>
                    <img src="pages/account/GIF_SETTINGS.gif" style="width: 1.5in; height: 1in; margin-left: 0px;" id="settings_gif">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">


                    <form id="registration_form" method="POST"> <!--action="actions/edit_profile.php" -->
                        <div class="input" id="inputfields" style="height: 400px;">

                            <button type="button" class="btn btn-secondary" id="openChangeYourPasswordModalBtn" data-bs-toggle="modal" data-bs-target="#modal_changeyourpassword"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Change Your Password
                            </button>
                            <br>
                            <button type="button" class="btn btn-secondary" id="openHistoryModalBtn" data-bs-toggle="modal" data-bs-target="#modal_history"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                History
                            </button>
                            <br>
                            <!-- <button type="button" class="btn btn-secondary" id="openAppearanceAndThemeModalBtn" data-bs-toggle="modal" data-bs-target="#modal_appearanceandtheme"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Appearance and Theme
                            </button>
                            <br>
                            <button type="button" class="btn btn-secondary" id="openTermsAndPrivacyPolicyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_termsandprivacypolicy"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Terms and Privacy Policy
                            </button> -->
                        </div>
                        
                            <button type="button" class="btn btn-secondary" id="sett_closeModalBtn" data-bs-dismiss="modal"
                            window.location.href = 'account_main.php';>Close</button>
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>
    <!-- <script>
        function openmodal_settings() {
            $('#modal_settings').modal('show');
        }
    </script> -->
    <!-- END SETTINGS MODAL -- FOR EDITING SETTINGS -->






    <!-- CHANGE PASSWORD MODAL -- FOR CHANGING YOUR PASSWORD -->
    <div class="modal fade" id="modal_changeyourpassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Your Password</h5>
                    <img src="pages/account/GIF_PASSWORD.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
                </div>
                <div class="modal-body">
                    <form id="change_password_form" method="POST" action="actions_admin/change_pword_admin.php">
                        <div class="input" id="inputfields" style="height: 350px;">

                            <div class="row">
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Enter old password</h>
                                <input type="password" class="oldpassword" name="oldpassword" id="cyp_row1" style="margin-top: 10px;"/>
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Enter new password</h>
                                <input type="password" class="newpassword" name="newpassword" id="cyp_row2" style="margin-top: 10px;"/>
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Confirm new password</h>
                                <input type="password" class="confirmnewpassword" name="confirmnewpassword" id="cyp_row3" style="margin-top: 10px;"/>
                            </div>
                        </div>
                        <button type="submit" class="submit" name="submit" id="sett_cyp_modalsave">Save</button>

                        <button type="button" class="btn btn-secondary" id="sett_cyp_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        document.getElementById("sett_cyp_modalsave").addEventListener("click", function(event) {
            //event.preventDefault(); // Prevent the form from being submitted

            <?php
                $password = $admin['password'];
            ?>
            
            let oldPassword = document.querySelector('.oldpassword').value;
            let newPassword = document.querySelector('.newpassword').value;
            let confirmNewPassword = document.querySelector('.confirmnewpassword').value;
            let password = "<?php echo $password; ?>"; // Echo the PHP variable as a JavaScript variable

            if (oldPassword === password) {
                if (newPassword.length !== 0) {
                    if (newPassword === confirmNewPassword) {
                        // alert("Password changed successfully");
                        document.getElementById("change_password_form").submit();
                    } else {
                        event.preventDefault();
                        alert("Passwords don't match");
                    }
                } else {
                    event.preventDefault();
                    alert("New password can't be empty");
                }
            } else {
                event.preventDefault();
                alert("Old password is incorrect");
            }
        });
    </script>
    <!-- END CHANGE PASSWORD MODAL -- FOR CHANGING YOUR PASSWORD -->

    
    
    <!-- HISTORY MODAL -- FOR VIEWING HISTORY -->
    <div class="modal fade" id="modal_history" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">History</h5>
                <img src="pages/account/GIF_HISTORY.gif" style="width: 1.75in; height: 1in; margin-left: 208px;" id="bginfo_gif">
                <!-- <img src="pages/account/HISTORY_GIF.gif" style="width: 1.5in; height: 1in; margin-left: 0px;" id="bginfo_gif"> -->
            </div>

                <div class="modal-body">
                    <!-- <form id="feedback_history_form" method="POST" action="actions/change_password.php"> -->
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-4" style="margin-bottom: 10px; margin-left: 0px;">
                            <h><b>Activity</b></h>
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-5" style="margin-bottom: 10px; margin-left: 0px;">
                            <h><b>Date</b></h>
                        </div>
                    </div>
                    
                    <div class="scrollable-content" id="inputfields" style="height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <!-- <thead>
                                <tr>
                                    <th class="col-5">Activities</th>
                                    <th class="col-5">Dates</th>
                                </tr>
                            </thead> -->
                            <tbody>
                                <?php
                                // Assuming both arrays have the same length
                                $count = count($activities);

                                for ($i = 0; $i < $count; $i++) {
                                ?>
                                <tr>
                                    <td class="col-5"><?php echo $activities[$i]; ?></td>
                                    <td class="col-5"><?php echo $dates[$i]; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <button type="submit" class="submit" name="submit" id="sett_cyp_modalsave">Save</button> -->

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_h_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmodal_history() {
        $('#modal_history').modal('show');
    }
    </script>
    <!-- END FEEDBACK HISTORY MODAL -- FOR VIEWING FEEDBACK HISTORY -->


    <!-- APPEARANCE AND THEME MODAL -- FOR CHANGING APPEARANCE AND THEME -->
    <!-- <div class="modal fade" id="modal_appearanceandtheme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Appearance and Theme</h5>
                    <img src="pages/account/GIF_THEMES.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
                </div>
                <div class="modal-body">
                    <h style="margin-top: 5px; margin-left: 10px;">Choose your theme:</h>
                    
                    <div class="scrollable-content" id="inputfields" style="height: 400px; overflow-y: auto;">

                            

                        <div class="card-body">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <div class="card border-0" id="default" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_DEFAULT.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Default</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <div class="card border-0" id="theme1" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME1.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Blue Water</h6>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body" style="margin-top: -30px;">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <div class="card border-0" id="theme2" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME2.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Green Archers</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <div class="card border-0" id="theme3" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME3.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Cold Blocks</h6>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                        
                        <div class="card-body" style="margin-top: -30px;">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <div class="card border-0" id="theme4" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME4.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Great Wizard</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <div class="card border-0" id="theme5" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME5.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Red Bug</h6>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <script>
                            // Add a click event handler for the "Default" card
                            document.getElementById('default').addEventListener('click', function() {
                                // Close the modal here (you need to provide modal closing code)
                                $('#modal_appearanceandtheme').modal('hide');
                                alert("No changes made");
                            });

                            // Add a click event handler for the "Theme1" card
                            document.getElementById('theme1').addEventListener('click', function() {
                                // Redirect to account_theme1.php
                                window.location.href = 'account_theme1.php';
                                alert("Your theme is successfully changed to Blue Water!");
                            });

                            // Add a click event handler for the "Theme2" card
                            document.getElementById('theme2').addEventListener('click', function() {
                                // Redirect to account_theme2.php
                                window.location.href = 'account_theme2.php';
                                alert("Your theme is successfully changed to Green Archers!");
                            });

                            // Add a click event handler for the "Theme3" card
                            document.getElementById('theme3').addEventListener('click', function() {
                                // Redirect to account_theme3.php
                                window.location.href = 'account_theme3.php';
                                alert("Your theme is successfully changed to Cold Blocks!");
                            });

                            // Add a click event handler for the "Theme2" card
                            document.getElementById('theme4').addEventListener('click', function() {
                                // Redirect to account_theme4.php
                                window.location.href = 'account_theme4.php';
                                alert("Your theme is successfully changed to Great Wizard!");
                            });

                            // Add a click event handler for the "Theme3" card
                            document.getElementById('theme5').addEventListener('click', function() {
                                // Redirect to account_theme5.php
                                window.location.href = 'account_theme5.php';
                                alert("Your theme is successfully changed to Red Bug!");
                            });
                        </script>


                    </div>

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_aat_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmodal_appearanceandtheme() {
        $('#modal_appearanceandtheme').modal('show');
    }
    </script> -->
    <!-- END APPEARANCE AND THEME MODAL -- FOR CHANGING APPEARANCE AND THEME -->


    <!-- TERMS AND POLICY MODAL -- FOR VIEWING TERMS AND POLICY -->
<div class="modal fade" id="modal_termsandprivacypolicy" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Terms and Privacy Policy</h5>
                    <img src="pages/account/GIF_TERMSPRIVACY.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
            </div>
            <div class="modal-body">
                <div class="scrollable-content" style="height: 400px; overflow-y: auto;">
                    <b>Customer Feedback Management System</b>
                        <br><br>
                        Effective Date: September 09, 2023
                        <br><br>
                        Thank you for using our Customer Feedback Management System. Please read the following terms and policies carefully before using our platform. By accessing and using this system, you agree to these terms and policies.
                        <br><br>
                        <b>User Registration</b>
                        <br>
                        Users are required to register for an account to access and use our system. When registering, you must provide accurate and complete information.
                        <br><br>
                        <b>Privacy</b>
                        <br>
                        Your privacy is important to us. Please review our Privacy Policy to understand how we collect, use, and protect your personal information.
                        <br><br>
                        <b>Feedback Submission</b>
                        <br>
                        Users are encouraged to submit honest and constructive feedback.
                        Feedback should not contain offensive, discriminatory, or harmful content.
                        <br><br>
                        <b>Moderation</b>
                        <br>
                        All submitted feedback is subject to moderation. We reserve the right to review and approve or reject feedback.
                        Moderation is conducted to maintain a respectful and safe environment.
                        <br><br>
                        <b>Intellectual Property</b>
                        <br>
                        All content, including feedback, on the system is protected by intellectual property rights. Users may not use or reproduce this content without authorization.
                        <br><br>
                        <b>User Conduct</b>
                        <br>
                        Users must not engage in any activities that violate laws or harm the system or its users.
                        Users must not attempt to access restricted areas of the system or compromise its security.
                        <br><br>
                        <b>Feedback Ownership</b>
                        <br>
                        Users retain ownership of the feedback they submit. However, by submitting feedback, users grant us a non-exclusive, royalty-free license to use, display, and reproduce the feedback.
                        <br><br>
                        <b>Termination</b>
                        <br>
                        We reserve the right to terminate or suspend a user's account for violating these terms and policies or for any other reason at our discretion.
                        <br><br>
                        <b>Disclaimer</b>
                        <br>
                        The system is provided "as is" without warranties of any kind. We do not guarantee the accuracy, completeness, or reliability of the content.
                        <br><br>
                        <b>Limitation of Liability</b>
                        <br>
                        We shall not be liable for any damages, including indirect or consequential damages, arising from the use of the system.
                        <br><br>
                        <b>Changes to Terms and Policies</b>
                        <br>
                        We may revise and update these terms and policies from time to time. It is the user's responsibility to review these terms periodically.
                        <br><br>
                        <b>Contact Information</b>
                        <br>
                        If you have any questions or concerns about these terms and policies, please contact us at Octawiz_Devbugs2023@gmail.com.
                        <br>
                    <h style="margin-top: 5px; margin-left: 10px; font-size: 10px;">
                        <!-- Your terms and policy text here -->
                    </h>
                </div>
                <!-- <button type="button" class="btn btn-secondary" style="margin-top: 10px; margin-left: 200px;" id="sett_tap_closeModalBtn" data-bs-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_tap_closeModalBtn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script>
    function openmodal_termsandprivacypolicy() {
        $('#modal_termsandprivacypolicy').modal('show');
    }
    </script>
    <!-- END TERMS AND POLICY MODAL -- FOR VIEWING TERMS AND POLICY -->




    <script>
        // Function to underline a link and remove underline from others
        function underlineLink(linkId) {
            const links = ["dashboardLink", "adminaccLink"];
            for (const id of links) {
                const link = document.getElementById(id);
                if (id === linkId) {
                    link.style.textDecoration = "underline";
                } else {
                    link.style.textDecoration = "none";
                }
            }
        }
        underlineLink("adminaccLink");

        document.getElementById("dashboardLink").addEventListener("click", function() {
            underlineLink("dashboardLink");
        });
    </script>
    

</body>
</html>









<script>
    function to_dashboard() {
        window.location.href = 'admin_main.php';
    }
</script>


<script>
    function to_adminacc() {
        window.location.href = 'admin_account.php';
    }
</script>





<script>
    function to_adminlogin() {
$.post("admin_login.php", {},function (data) {
      $("#contents").html(data);  
    });
}   
</script>


<script>
    function to_back() {
        $.post("pages/account/back_acc.php", {},function (data) {
            $("#nav_contents").html(data);
        });
    }
</script>

<script>
    function to_nav(){
        $.post("navigation/nav.php", {}, function (data) {
            $("#nav_contents").html(data);
        });
    }
</script>

