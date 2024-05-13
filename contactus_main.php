<?php
session_start();  // Start the session to access session variables

// Check if the user is logged in (you can adjust this based on your session variable)
if (isset($_SESSION['customerID'])) {
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
        $customerID = $_SESSION['customerID'];

        $query = $conn->prepare("SELECT firstName, middleName, lastName, street, barangay, municipality, province, zipcode, birthdate, gender,
            phoneNumber, image FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();





        // //FETCH TBL_FEEDBACK FOR FEEDBACK HISTORY LIST
        // // Assuming you have a valid PDO connection in $conn
        // // SQL query to select all "firstName" values
        // // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        // $sql1 = "SELECT feedback FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql2 = "SELECT suggestion FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql3 = "SELECT question FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql4 = "SELECT rating FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql5 = "SELECT date FROM tbl_feedback WHERE customer_ID = $customerID";
        // // Prepare and execute the query
        // $stmt1 = $conn->prepare($sql1);
        // $stmt2 = $conn->prepare($sql2);
        // $stmt3 = $conn->prepare($sql3);
        // $stmt4 = $conn->prepare($sql4);
        // $stmt5 = $conn->prepare($sql5);
        // $stmt1->execute();
        // $stmt2->execute();
        // $stmt3->execute();
        // $stmt4->execute();
        // $stmt5->execute();

        // // Fetch all the "firstName" values into an array
        // $feedbacks = $stmt1->fetchAll(PDO::FETCH_COLUMN);
        // $suggestions = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        // $questions = $stmt3->fetchAll(PDO::FETCH_COLUMN);
        // $ratings = $stmt4->fetchAll(PDO::FETCH_COLUMN);
        // $dates = $stmt5->fetchAll(PDO::FETCH_COLUMN);

        // // $firstNames now contains an array of all "firstName" values
        // //END FETCH FEEDBACK FOR FEEDBACK LIST





        // Fetch the user's information
        $user = $query->fetch(PDO::FETCH_ASSOC);

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

        // $customerID = $_SESSION['customer_ID'];
        // $firstName = $user['firstName'];
        $image = $user['image'];


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
    <link rel="stylesheet" href="pages/contactUs/style_cu.css">   <!--nothing happened on this link-->

    
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="" style="width: 7%; margin-left: 10px;">
            <img src="pages/home/LOGO.png" class="img-fluid" alt="">
        </div> 

        <div class="container-fluid">
            <a class="navbar-brand" id="logoname">Octawiz-Devbugs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="m-2">
                    <button class="btn btn-dark" type="button" id="homeLink" onclick="to_home()" href="home_main.php">
                        Home
                    </button>
                    <button class="btn btn-dark" type="button" id="aboutUsLink" onclick="to_aboutUs()" href="aboutus_main.php">
                        About Us
                    </button>
                    <button class="btn btn-dark" type="button" id="contactUsLink" onclick="to_contactUs()" href="contactus_main.php">
                        Contact Us
                    </button>
                </div>
            </div>

            
            <button type="button" class="btn btn-secondary" id="openCustomerMessagesModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customess"
                style="position: absolute; margin-left: 1030px; margin-top: 0px;"
                >Messages<span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                
                    <?php
                        $customerID = $_SESSION['customerID'];
                        // Fetch the count of new feedbacks for today
                        $sqlReply = "SELECT COUNT(reply_ID) AS replyCount FROM tbl_reply WHERE customer_ID = :customerID";
                        $stmtReply = $conn->prepare($sqlReply);
                        $stmtReply->bindParam(':customerID', $customerID, PDO::PARAM_INT); // Corrected the variable name here
                        $stmtReply->execute();
                        $replyCount = $stmtReply->fetchColumn();
                        echo $replyCount;
                    ?>

                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>


            




            

            <?php
                $customerID = $_SESSION['customerID'];

                // Fetch the count of new feedbacks for today
                $sqlReply = "
                    SELECT COUNT(DISTINCT DATE(tbl_reply.date)) AS replyCount
                    FROM tbl_reply
                    WHERE customer_ID = :customerID
                ";
                $stmtReply = $conn->prepare($sqlReply);
                $stmtReply->bindValue(':customerID', $customerID, PDO::PARAM_INT);
                $stmtReply->execute();
                $replyCount = $stmtReply->fetchColumn();

                // $sqlReply = "SELECT COUNT(reply_ID) AS replyCount FROM tbl_reply
                //             WHERE customer_ID = :customerID";
                // $stmtReply = $conn->prepare($sqlReply);
                // $stmtReply->bindValue(':customerID', $customerID, PDO::PARAM_INT);
                // $stmtReply->execute();
                // $replyCount = $stmtReply->fetchColumn();

                // Fetch and display customer registrations and feedback submissions
                $sqlNotifications = "
                    SELECT CONCAT(firstName, ' ', lastName) AS name, dateAdded AS date
                    FROM tbl_customer_info
                    WHERE customer_ID = :customerID
                    ORDER BY date DESC
                ";
                $stmtNotifications = $conn->prepare($sqlNotifications);
                $stmtNotifications->bindValue(':customerID', $customerID, PDO::PARAM_INT);
                $stmtNotifications->execute();
                $notifications = $stmtNotifications->fetchAll();
            ?>

            <button type="button" class="btn btn-secondary position-relative" id="openCustomerNotifModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customernotif" style="margin-right: 25px;">
                Notifications
                <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo $replyCount; ?>
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>

            <!-- CUSTOMER NOTIFICATIONS MODAL -- FOR VIEWING CUSTOMER NOTIFICATIONS -->
            <div class="modal fade" id="modal_customernotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-left: 500px; margin-top: -10px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Notifications</h3>
                            <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                        </div>

                        <div class="scrollable-content" id="inputfields" style="height: 500px; overflow-y: auto; color: black; background: lightgray;">
                            <div class="" style="position: relative;">
                                <?php
                                foreach ($notifications as $notification) {
                                    // Fetch the number of messages for the current notification
                                    $messagesCount = $replyCount;

                                    for ($i = 0; $i < $messagesCount; $i++) {
                                        echo '<div class="row" style="background-color: white; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                            border-radius: 5px; font-size: 20px; width: 450px; margin-left: 15px; margin-top: 20px;">';

                                        echo '<p style="margin-top: 10px;"><strong>Admin</strong> has messaged you.</p>';
                                        
                                        // Display relative date and time below
                                        echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['date']) . '</p>';

                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="modal-footer" style="height: 70px;">
                            <button type="button" class="btn btn-primary" id="openCustomerReplyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customess" style="position: absolute; width: 100px; margin-right: 370px; margin-top: 5px"
                            >View all</button>
                            <button type="button" class="btn btn-secondary float-end" id="customernotif_closeModalBtn" data-bs-dismiss="modal" style="position: absolute; margin-top: 15px; margin-bottom: 15px; margin-right: 5px;"
                            >Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openmodal_customernotif() {
                    $('#modal_customernotif').modal('show');
                }
            </script>
            <!-- END CUSTOMER NOTIFICATIONS MODAL -- FOR VIEWING CUSTOMER NOTIFICATIONS -->





            <!-- CUSTOMER MESSAGES MODAL -- FOR VIEWING CUSTOMER MESSAGES -->
            <div class="modal fade" id="modal_customess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-left: 250px; margin-top: 20px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Messages</h3>
                        </div>

                        <div class="scrollable-content" id="messageContent" style="height: 450px; padding: 20px; overflow-y: auto; color: black;">
                            <div class="">

                                <?php
                                $customerID = $_SESSION['customerID'];

                                $sql = "SELECT 
                                        'Admin' AS Fullname,
                                        reply AS Message,
                                        date AS Date
                                    FROM tbl_reply
                                    WHERE customer_ID = :customerID

                                    UNION

                                    SELECT 
                                        CONCAT(firstName, ' ', lastName) AS Fullname,
                                        message AS Message,
                                        date AS Date
                                    FROM tbl_message
                                    WHERE customer_ID = :customerID

                                    ORDER BY Date DESC";

                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':customerID', $customerID);
                                $stmt->execute();
                                $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>

                                <?php
                                // Output replies in the alternative design
                                foreach ($replies as $reply) {
                                    ?>
                                    <div class="reply-container">
                                        <div class="row" style="background-color: <?php echo ($reply["Fullname"] === 'Admin') ? '#f0ecff' : '#ecffed'; ?>; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166); border-radius: 15px; margin-bottom: 10px;">
                                            <strong class="reply-sender" style="margin-top: 10px;"><?php echo $reply["Fullname"]; ?></strong>
                                            <p class="reply-content" style="font-size: 20px;"><?php echo $reply["Message"]; ?></p>
                                        </div>
                                        <p class="reply-date text-muted" style="margin-bottom: 0px; color: blue;"><?php echo formatRelativeDate($reply["Date"]); ?></p>
                                    </div>

                                    <hr>
                                <?php
                                }

                                // Check if no messages found
                                if (empty($replies)) {
                                    echo "<p>No messages found</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                            // Function to format relative date and time
                            function formatRelativeDate($date)
                            {
                                $now = new DateTime();
                                $formattedDate = new DateTime($date);
                                $interval = $now->diff($formattedDate);

                                if ($interval->days == 0) {
                                    return 'Today @ ' . $formattedDate->format('h:i A'); // 12-hour format with AM/PM
                                } elseif ($interval->days == 1) {
                                    return 'Yesterday @ ' . $formattedDate->format('h:i A');
                                } else {
                                    return $interval->days . ' days ago at ' . $formattedDate->format('h:i A');
                                }
                            }
                        ?>

                        <div>
                            <button type="button" class="btn btn-primary" id="openCustomerReplyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customerreply" style="width: 150px; margin-left: 15px; margin-top: 15px"
                            >Reply</button>
                            <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px; margin-bottom: 15px; margin-right: 15px;" id="customess_closeModalBtn" data-bs-dismiss="modal"
                            >Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openmodal_customess() {
                    $('#modal_customess').modal('show');
                }
            </script>
            <!-- END CUSTOMER MESSAGES MODAL -- FOR VIEWING CUSTOMER MESSAGES -->







            <!-- CUSTOMER REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->
            <div class="modal fade" id="modal_customerreply" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                style="margin-left: 0px; margin-top: 150px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="row" id="messageContent" style="height: 230px; padding: 20px; overflow-y: auto; color: black;">
                            <!-- Previous messages here -->

                            <!-- Reply form -->
                            <form action="actions/insert_messreply.php" method="post">

                                <!-- Hidden input fields for additional information -->
                                <?php
                                // Fetch additional information from tbl_message based on customer_ID
                                if (isset($_SESSION['customerID'])) {
                                    $customerID = $_SESSION['customerID'];
                                    $sql = "SELECT firstName, lastName, email, contactNumber FROM tbl_message WHERE customer_ID = :customerID";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':customerID', $customerID);
                                    $stmt->execute();
                                    $customerInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                                }
                                ?>

                                <!-- Display additional information -->
                                <?php if (isset($customerInfo)) : ?>
                                    <!-- Hidden input fields to include additional information in the form submission -->
                                    <input type="hidden" name="firstname" value="<?php echo $customerInfo['firstName']; ?>">
                                    <input type="hidden" name="lastname" value="<?php echo $customerInfo['lastName']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $customerInfo['email']; ?>">
                                    <input type="hidden" name="contactnum" value="<?php echo $customerInfo['contactNumber']; ?>">
                                <?php endif; ?>

                                <!-- Form fields for the reply -->
                                <div class="form-group">
                                    <label class="text-muted" for="replyTextArea" style="margin-bottom: 10px;">Replying to: <strong class="replysender text-unmuted">Admin</strong></label>
                                    <textarea class="form-control" id="replyTextArea" name="message" rows="3" required></textarea>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Send Reply</button>
                                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 25px; margin-bottom: 0px; margin-right: 0px;" id="customess_closeModalBtn" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>

            <script>
                function openmodal_customerreply(replyId, customerId, senderName) {
                    // Set the message ID, customer ID, and sender name in the reply modal
                    $('#modal_customerreply').find('[name="reply_ID"]').val(replyId);
                    $('#modal_customerreply').find('[name="customer_ID"]').val(customerId);
                    $('#modal_customerreply').find('.reply-sender').text(senderName);

                    // Show the reply modal using Bootstrap's modal method
                    $('#modal_customerreply').modal('show');
                }
            </script>
            <!-- CUSTOMER REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->


            <img src="images/<?php echo $image; ?>" class="img-fluid zoomable-image rounded-square" onclick="to_account()" style="width: 25px; height: 25px; border-radius: 12.5px;">

            <div class = " m-2 text-light" >   
                <b class = "bg-transparent "  id="accountLink" onclick="to_account()" style=" cursor: pointer;"> <img src="navigation/user.png" alt="">Account</b>
            </div>

        </div>
    </nav>

    <div id="cu_body">

        <div class="row col-7">
            <div class="row" style="position: absolute; margin-left: -11px; margin-top: -281px; width: 44%; height: 580px; background: rgba(0, 0, 0, 0.2);">
            </div>
            <div class="row" style="position: absolute; margin-left: 200px; margin-top: -200px; width: 35%; height: 350px; border-radius: 10px; background: rgba(255, 255, 255, 0.2);"> <!--rgba(0, 0, 255, 0.5)BLUE-->
            </div>
            <img src="pages/contactUs/ICON_CONTACT_US2.png" style="position: absolute; width: 28%; margin-left: 20px; margin-top: -190px;
                filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(0deg);">

            <div class="row">
                <div class="col-2 bg-transparent"></div>
                <div class="col-8 bg-transparent text-center text-light" id="cu_message" style="position: absolute; margin-left: -100px; margin-top: -190px;">
                    <h1 style="color: lightblue;">We'd love to hear</h1>
                    <h1 style="position: absolute; font-size: 70px; color: white; margin-left: 550px; margin-top: -25px; filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20));"
                    >from you !</h1>
                    <p style="margin-top: 140px; margin-left: 250px; font-size: 20px; font-style: italic;">Whether you have questions about
                        <br>features, trials, pricing, need a demo,
                        <br>or anything else, our team is ready to
                        <br>answer your questions.</p>
                </div>
                <div class="col-2 bg-transparent"></div>
            </div>
        </div>

        <div class="row col-5">
            <form id="feedback_form" method="POST" action="actions/insert_message.php">
                <div class="col-12 col-md-8 offset-md-2 form-container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>Send us message</h1>
                        </div>
                        <div class="col-md-6">
                            <input type="text" placeholder="First Name" name="firstname" id="fn">
                        </div>
                        <div class="col-md-6">
                            <input type="text" placeholder="Last Name" name="lastname" id="ln">
                        </div>
                        <div class="col-md-6">
                            <input type="email" placeholder="Email" name="email" id="em">
                        </div>
                        <div class="col-md-6">
                            <input type="tel" placeholder="Contact Number" name="contactnum" id="cn">
                        </div>
                        <div class="col-12">
                            <textarea placeholder="Type your message here" id="m" name="message" rows="4"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



</body>
</html>

<script>
    function to_navigation() {
$.post("pages/nav/nav.php", {},function (data) {
      $("#contents").html(data);  
    });
}  
</script>



<script>
    function to_home() {
        window.location.href = 'home_main.php';
    }
</script>

<script>
    function to_aboutUs() {
        window.location.href = 'aboutus_main.php';
    }
</script>

<script>
    function to_contactUs() {
        window.location.href = 'contactus_main.php';
    }
</script>

<script>
    function to_account() {
        window.location.href = 'account_main.php';
    }
</script>

<script>
    function to_settings() {
        window.location.href = 'settings_main.php';
    }
</script>





<script>
    function to_home_t1() {
        window.location.href = 'home_theme1.php';
    }
</script>

<script>
    function to_aboutUs_t1() {
        window.location.href = 'aboutus_theme1.php';
    }
</script>

<script>
    function to_contactUs_t1() {
        window.location.href = 'contactus_theme1.php';
    }
</script>

<script>
    function to_account_t1() {
        window.location.href = 'account_theme1.php';
    }
</script>

<script>
    function to_settings_t1() {
        window.location.href = 'settings_theme1.php';
    }
</script>



<script>
    function to_home_t2() {
        window.location.href = 'home_theme2.php';
    }
</script>

<script>
    function to_aboutUs_t2() {
        window.location.href = 'aboutus_theme2.php';
    }
</script>

<script>
    function to_contactUs_t2() {
        window.location.href = 'contactus_theme2.php';
    }
</script>

<script>
    function to_account_t2() {
        window.location.href = 'account_theme2.php';
    }
</script>

<script>
    function to_settings_t2() {
        window.location.href = 'settings_theme2.php';
    }
</script>







<script>
    function to_home_t3() {
        window.location.href = 'home_theme3.php';
    }
</script>

<script>
    function to_aboutUs_t3() {
        window.location.href = 'aboutus_theme3.php';
    }
</script>

<script>
    function to_contactUs_t3() {
        window.location.href = 'contactus_theme3.php';
    }
</script>

<script>
    function to_account_t3() {
        window.location.href = 'account_theme3.php';
    }
</script>

<script>
    function to_settings_t3() {
        window.location.href = 'settings_theme3.php';
    }
</script>


<script>
    function to_home_t4() {
        window.location.href = 'home_theme4.php';
    }
</script>

<script>
    function to_aboutUs_t4() {
        window.location.href = 'aboutus_theme4.php';
    }
</script>

<script>
    function to_contactUs_t4() {
        window.location.href = 'contactus_theme4.php';
    }
</script>

<script>
    function to_account_t4() {
        window.location.href = 'account_theme4.php';
    }
</script>

<script>
    function to_settings_t4() {
        window.location.href = 'settings_theme4.php';
    }
</script>







<script>
    function to_home_t5() {
        window.location.href = 'home_theme5.php';
    }
</script>

<script>
    function to_aboutUs_t5() {
        window.location.href = 'aboutus_theme5.php';
    }
</script>

<script>
    function to_contactUs_t5() {
        window.location.href = 'contactus_theme5.php';
    }
</script>

<script>
    function to_account_t5() {
        window.location.href = 'account_theme5.php';
    }
</script>

<script>
    function to_settings_t5() {
        window.location.href = 'settings_theme5.php';
    }
</script>





<script>
    function to_login() {
$.post("login_main.php", {},function (data) {
      $("#contents").html(data);  
    });
}   
</script>


<!-- 
<div class="container-fluid" id="cu_body">
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="pages/contactUs/DEVBUGS (CONTACT US).png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="pages/contactUs/DEVBUGS (CONTACT US).png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="pages/contactUs/DEVBUGS (CONTACT US).png" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

   -->