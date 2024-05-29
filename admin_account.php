<?php
session_start();  // Start the session to access session variables

// Check if the user is logged in (you can adjust this based on your session variable)
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

        // Get the customer's first name and last name from the database based on the customer ID
        $customerID = $_SESSION['adminID'];
        $query = $conn->prepare("SELECT firstName, middleName, lastName, street, barangay, municipality, province, zipcode, birthdate, gender,
            phoneNumber, password, image FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();



        // Fetch the user's information
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Check if data was found in the database
        if ($user !== false) {
            // $customerID = $user['customer_ID'];
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
            $image = $user['image'];
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
            $image = '';
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
        


        //FETCH ACTIVITY LOGS FOR HISTORY LIST
        // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        $sql1 = "SELECT activity FROM tbl_activity_logs WHERE admin_ID = $adminID ORDER BY dateAdded DESC";
        $sql2 = "SELECT dateAdded FROM tbl_activity_logs WHERE admin_ID = $adminID ORDER BY dateAdded DESC";
        // Prepare and execute the query
        $stmt1 = $conn->prepare($sql1);
        $stmt2 = $conn->prepare($sql2);
        $stmt1->execute();
        $stmt2->execute();

        // Fetch all the "firstName" values into an array
        $activities = $stmt1->fetchAll(PDO::FETCH_COLUMN);
        $dates = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        //END FETCH ACTIVITY LOGS FOR HISTORY LIST



        

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
$dbname = "nasara";

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

    <title>Nasara - Admin</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/admin_account/style_adacc.css">
















    <nav class="navbar navbar-expand-lg navbar-light bg-primary">

        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">

        <!-- <form action="actions_admin/logoutAction_admin.php" method="post">
            <button class="btn" type="submit" id="logout" onclick="window.location.href='login_main.php'"
            >Log Out</button>
        </form> -->

        <img src="images_admin/<?php echo $adminimage; ?>" id="icon_profile" class="img-fluid zoomable-image rounded-square" onclick="to_adminacc()">
        
    </nav>








    <!-- ADMIN DASHBOARD - FOR VIEWING ADMIN DASHBOARD -->
    <div class="row" id="dash_bg">

        <div class="col-1">
            <div class="card-body text-center d-flex justify-content-center" id="cards_body1">

            <div class="div-home text-center d-flex align-items-center justify-content-center" id="div_home" onclick="to_adminhome()" href="home_main.php">
                    <button class="btn btn-secondary" type="button" id="icon_home">
                        <i class="fas fa-home"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Home</h3>
                    </button>
                </div>

                <div class="div-feedbacks text-center d-flex align-items-center justify-content-center" id="div_feedbacks" onclick="to_adminfeedbacks()" href="admin_feedbacks.php">
                    <button class="btn btn-secondary" type="button" id="icon_feedbacks">
                        <i class="fas fa-comment"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Feedbacks</h3>
                    </button>
                </div>

                <div class="div-customers text-center d-flex align-items-center justify-content-center" id="div_customers" onclick="to_admincustomers()" href="admin_customers.php">
                    <button class="btn btn-secondary" type="button" id="icon_customers">
                        <i class="fas fa-users"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Customers</h3>
                    </button>
                </div>

                <div class="div-notifications text-center d-flex align-items-center justify-content-center" id="div_notifications" onclick="to_adminnotifications()" href="admin_notifications.php">
                    <button class="btn btn-secondary" type="button" id="icon_notifications">
                        <i class="fas fa-bell"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Notifications</h3>
                        <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php

                            // Fetch the count of activity logs for today
                            $sqlActivityLogs1 = "SELECT COUNT(*) AS activityLogCount1 FROM tbl_activity_logs WHERE activity='Registered an account' AND DATE(dateAdded) = CURDATE()"; 
                            $stmtActivityLogs1 = $conn->prepare($sqlActivityLogs1);
                            $stmtActivityLogs1->execute();
                            $activityLogCount1 = $stmtActivityLogs1->fetchColumn();

                            // Fetch the count of activity logs for today
                            // $sqlActivityLogs2 = "SELECT COUNT(*) AS activityLogCount2 FROM tbl_activity_logs WHERE activity='Updated the profile' AND DATE(dateAdded) = CURDATE()"; 
                            // $stmtActivityLogs2 = $conn->prepare($sqlActivityLogs2);
                            // $stmtActivityLogs2->execute();
                            // $activityLogCount2 = $stmtActivityLogs2->fetchColumn();


                            // // Fetch the count of activity logs for today
                            // $sqlActivityLogs3 = "SELECT COUNT(*) AS activityLogCount3 FROM tbl_activity_logs WHERE activity='Changed Profile Picture' AND DATE(dateAdded) = CURDATE()"; 
                            // $stmtActivityLogs3 = $conn->prepare($sqlActivityLogs3);
                            // $stmtActivityLogs3->execute();
                            // $activityLogCount3 = $stmtActivityLogs3->fetchColumn();
                            
                            // Fetch the count of activity logs for today
                            $sqlActivityLogs2 = "SELECT COUNT(*) AS activityLogCount2 FROM tbl_activity_logs WHERE activity='Sent feedback' AND DATE(dateAdded) = CURDATE()"; 
                            $stmtActivityLogs2 = $conn->prepare($sqlActivityLogs2);
                            $stmtActivityLogs2->execute();
                            $activityLogCount2 = $stmtActivityLogs2->fetchColumn();
                            
                            // Fetch the count of activity logs for today
                            $sqlActivityLogs3 = "SELECT COUNT(*) AS activityLogCount3 FROM tbl_activity_logs WHERE activity='Sent audio feedback' AND DATE(dateAdded) = CURDATE()"; 
                            $stmtActivityLogs3 = $conn->prepare($sqlActivityLogs3);
                            $stmtActivityLogs3->execute();
                            $activityLogCount3 = $stmtActivityLogs3->fetchColumn();

                            // Calculate and display the combined count of feedbacks, new customers, and activity logs
                            $totalNotifications = $activityLogCount1 + $activityLogCount2 + $activityLogCount3;
                            echo $totalNotifications;
                            ?>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                </div>
                
                <div class="div-history text-center d-flex align-items-center justify-content-center" id="div_history" onclick="to_adminhistory()" href="admin_history.php">
                    <button class="btn btn-secondary" type="button" id="icon_history">
                        <i class="fas fa-history"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">History</h3>
                    </button>
                </div>
                
                <div class="div-settings text-center d-flex align-items-center justify-content-center" id="div_settings" onclick="to_adminsettings()" href="admin_settings.php">
                    <button class="btn btn-secondary" type="button" id="icon_settings">
                        <i class="fas fa-cog"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Settings</h3>
                    </button>
                </div>
                
                <div class="div-logout text-center d-flex align-items-center justify-content-center" id="div_logout" data-bs-toggle="modal" data-bs-target="#modal_logout">
                    <button class="btn btn-secondary" type="submit" id="icon_logout" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Logout</h3>
                    </button>
                </div>
                
                <div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="modal_logoutLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_logoutLabel">Logout Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to logout?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary" onclick="logout()">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function logout() {
                        // Perform logout action
                        $.ajax({
                            url: 'actions_admin/logoutAction_admin.php',
                            type: 'POST',
                            success: function(response) {
                                // Redirect to the logout page
                                window.location.href = './login_main.php';
                            },
                            error: function(xhr, status, error) {
                                // Handle errors if any
                                console.error(xhr.responseText);
                            }
                        });
                    }

                    // Optional: Handle modal hidden event to ensure proper cleanup
                    $('#modal_logout').on('hidden.bs.modal', function () {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    });
                </script>

            </div>
        </div>

       <!-- ADMIN NOTIFICATIONS MODAL -- FOR VIEWING ADMIN NOTIFICATIONS -->
       <div class="modal fade" id="modal_adminnotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Notifications</h3>
                        <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                    </div>

                    <div class="scrollable-content" id="inputfields" style="height: 500px; overflow-y: auto; color: black; background: white;">
                        <div class="" style="position: relative;">
                        <?php
                            // Fetch and display customer registrations and feedback submissions
                            
                            // $sqlNotifications = "
                            //     (SELECT CONCAT(firstName, ' ', lastName) AS name, dateAdded AS date, 'registration' AS type
                            //     FROM tbl_customer_info) 
                            //     UNION
                            //     (SELECT CONCAT(firstName, ' ', lastName) AS name, date, 'feedback' AS type
                            //     FROM tbl_customer_info ci
                            //     JOIN tbl_feedback f ON ci.customer_id = f.customer_id)
                            //     ORDER BY date DESC
                            // ";


                            $sqlNotifications = "
                                (SELECT CONCAT(firstName, ' ', lastName) AS name, dateAdded AS date, 'registration' AS type
                                FROM tbl_customer_info) 
                                UNION
                                (SELECT CONCAT(firstName, ' ', lastName) AS name, date, 'feedback' AS type
                                FROM tbl_customer_info ci
                                JOIN tbl_feedback f ON ci.customer_id = f.customer_id)
                                UNION
                                (SELECT CONCAT(firstName, ' ', lastName) AS name, dateModified AS date, 'profile_update' AS type
                                FROM tbl_customer_info ci
                                JOIN tbl_activity_logs al ON ci.customer_id = al.customer_ID
                                WHERE al.activity = 'Updated the profile')
                                ORDER BY date DESC
                            ";


                            $stmtNotifications = $conn->prepare($sqlNotifications);
                            $stmtNotifications->execute();
                            $notifications = $stmtNotifications->fetchAll();

                            $todayNotifications = [];
                            $yesterdayNotifications = [];
                            $olderNotifications = [];

                            $now = new DateTime();
                            $yesterday = (clone $now)->modify('-1 day');

                            foreach ($notifications as $notification) {
                                $notificationDate = new DateTime($notification['date']);

                                if ($notificationDate->format('Y-m-d') == $now->format('Y-m-d')) {
                                    $todayNotifications[] = $notification;
                                } elseif ($notificationDate->format('Y-m-d') == $yesterday->format('Y-m-d')) {
                                    $yesterdayNotifications[] = $notification;
                                } else {
                                    $olderNotifications[] = $notification;
                                }
                            }

                            function displayNotifications($notifications, $heading, $marginTop) {
                                echo '<h4 style="margin-top: ' . $marginTop . '; margin-left: 15px; font-size: 20px; color: gray;">' . $heading . '</h4>';
                                foreach ($notifications as $notification) {
                                    echo '<div class="row" style="background-color: #f0ecff; border: solid 1px lightblue; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166); 
                                        border-radius: 5px; font-size: 20px; width: 450px; margin-left: 15px; margin-top: 10px;">';

                                        // if ($notification['type'] == 'registration') {
                                        //     echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has registered an account.</p>';
                                        // } elseif ($notification['type'] == 'feedback') {
                                        //     echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has submitted feedback.</p>';
                                        // }

                                        if ($notification['type'] == 'registration') {
                                            echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has registered an account.</p>';
                                        } elseif ($notification['type'] == 'feedback') {
                                            echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has submitted feedback.</p>';
                                        } elseif ($notification['type'] == 'profile_update') {
                                            echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has updated profile.</p>';
                                        }
                                        

                                    echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['date'], $heading) . '</p>';
                                    echo '</div>';
                                }
                            }

                            displayNotifications($todayNotifications, 'Today', '20px');
                            displayNotifications($yesterdayNotifications, 'Yesterday', '20px');
                            displayNotifications($olderNotifications, 'Older', '20px');

                            // Function to format relative date and time
                            function formatRelativeDate($date, $category)
                            {
                                $formattedDate = new DateTime($date);

                                if ($category === 'Today') {
                                    return 'Today @ ' . $formattedDate->format('h:i A'); // 12-hour format with AM/PM
                                } elseif ($category === 'Yesterday') {
                                    return 'Yesterday @ ' . $formattedDate->format('h:i A');
                                } else {
                                    $interval = (new DateTime())->diff($formattedDate);
                                    return $interval->days . ' days ago @ ' . $formattedDate->format('h:i A');
                                }
                            }
                        ?>
                        </div>
                    </div>

                    <div class="modal-footer" style="height: 70px;">
                        <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px; margin-bottom: 15px; margin-right: 5px;" id="adminnotif_closeModalBtn" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openmodal_adminnotif() {
                $('#modal_adminnotif').modal('show');
                document.getElementById('notification-badge').textContent = '0';
            }
        </script>


    
    <!-- ADMIN HISTORY MODAL -- FOR VIEWING HISTORY -->
    <div class="modal fade" id="modal_adminhistory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">History</h3>
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
    <!-- END ADMIN HISTORY MODAL -- FOR VIEWING FEEDBACK HISTORY -->









        <!-- SETTINGS MODAL -- FOR EDITING SETTINGS -->
    <div class="modal fade custom-fade" id="modal_settings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Settings</h3>
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
                    <h3 class="modal-title" id="staticBackdropLabel">Change Your Password</h3>
                    <img src="pages/account/GIF_PASSWORD.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
                </div>
                <div class="modal-body">
                    <form id="change_password_form" method="POST" action="actions_admin/change_pword_admin(me).php">
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

    





































    <div class="col-11">

            <div class="body">
            
                <!-- <h5 style="position: absolute; margin-top: 40px; margin-bottom: 25px; margin-left: 140px; font-size: 70px; color: gray;"
                >Profile</h5>
                <img src="icons/GIF_REPORT.gif" style="position: absolute; width: 2.15in; height: 1.1in; margin-left: 480px; margin-top: 35px;" id="newfb_gif"> -->

                <div class="container text-center d-flex align-items-center justify-content-center bg-transparent" id="div_profile_page">
                
                
                    <div class="row" style="background-color: #ecffed; width: 1140px; padding-bottom: 50px; margin-left: 170px; margin-top: 60px;
                        border-radius: 20px; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.166);">

                        <div class="">
                            <div class="m-2">
                                <?php
                                    $sql = "SELECT image FROM tbl_admin WHERE admin_ID = :adminID";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':adminID', $adminID, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $adminimage = $result['image'];
                                ?>

                                <img src="images_admin/<?php echo $adminimage; ?>" class="img-fluid zoomable-image rounded-square" style="width: 3in; height: 3in;">

                                <i class="fa fa-camera" onclick="openChangeProfilePicModal()" id="icon_camera"></i>
                                        
                            </div>
                        </div>



                        <div class="row text-center d-flex align-items-center justify-content-center" style="width: 1500px;">
                            <h1 class="" style="color: slateblue; width: 1500px; font-size: 90px; margin-left: 0px; margin-top: 0px;">
                                <?php echo $userName; ?>
                            </h1>
                            <!-- <p class="text-light" name="bio" style="width: 300px; margin-left: -30px;">"Trust the Process, Everything takes Time."</p> -->
                            <button type="button" class="btn btn-primary" id="icon_edit_profile" data-bs-toggle="modal" data-bs-target="#modal_profile"
                                    style="width: 200px; height: 44px; margin-top: 0px">
                                <i class="fas fa-pencil-alt"></i> Edit Profile
                            </button>

                        </div>
                    </div>

                </div>
            </div>

        </div>





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
                            <img src="images_admin/<?php echo $image; ?>" id="selectedImage" style="width: 2in; height: 2in; margin-bottom: 20px;">
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
    












        <!--////////////////////////OLD////////////////////////////-->













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
    function to_adminhome() {
        window.location.href = 'admin_main.php';
    }
    function to_adminacc() {
        window.location.href = 'admin_account.php';
    }
    function to_adminfeedbacks() {
        window.location.href = 'admin_feedbacks.php';
    }
    function to_admincustomers() {
        window.location.href = 'admin_customers.php';
    }
    function to_adminnotifications() {
        window.location.href = 'admin_notifications.php';
    }
    function to_adminhistory() {
        window.location.href = 'admin_history.php';
    }
    function to_adminsettings() {
        window.location.href = 'admin_settings.php';
    }
    function to_adminlogin() {
        $.post("admin_login.php", {},function (data) {
            $("#contents").html(data);  
        });
    }  
</script>