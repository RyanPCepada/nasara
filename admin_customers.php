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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--FOR PIE CHART-->

    <title>Nasara - Admin</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/admin_customers/style_adcustomers.css">

    
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">
        
        <form method="post" action="search_display.php" style="width: 300px; margin-left: 950px;">
            <input class="form-control me-2" type="text" name="search" placeholder="Search" aria-label="Search" style="width: 250px;">
            <button class="btn btn-light" type="submit" name="submit" style="position: absolute; margin-left: 252px; margin-top: -38px;"><i class="fas fa-search"></i></button>
        </form>

        <img src="images_admin/<?php echo $adminimage; ?>" id="icon_profile" class="img-fluid zoomable-image rounded-square" onclick="to_adminacc()">
    </nav>








    <!-- ADMIN DASHBOARD - FOR VIEWING ADMIN DASHBOARD -->
    <div class="row" id="dash_bg">

        <div class="col-1">
            <div class="card-body text-center d-flex justify-content-center" id="cards_body1">

                <div class="div-home text-center d-flex align-items-center justify-content-center" id="div_home" onclick="to_adminhome()" href="home_main.php">
                    <button class="btn btn-secondary" type="button" id="icon_home">
                        <i class="fas fa-chart-line"></i>
                        <h3 style="margin-top: -39px; margin-left: 60px;">Dashboard</h3>
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

    


    
















        <div class="col-11">

            <div class="body">
            
                <h5 style="position: absolute; margin-top: 40px; margin-bottom: 25px; margin-left: 210px; font-size: 70px; color: gray;"
                >Customers</h5>
                <img src="icons/GIF_REPORT.gif" style="position: absolute; width: 2.15in; height: 1.1in; margin-left: 1150px; margin-top: 35px;" id="newfb_gif">

                <div class="container">
                
                    <!-- <div class="modal-body" id="dashbody" style="justify-content: center; background: yellow;">  BODY COLOR -->
                




                    <div class="row">

                        <div class="card-body" id="cards_body2" style="justify-content: center; background: white;">
                        
                            <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">Customers list</h5>
                            
                            <h6 style="position: absolute; margin-top: -12px; margin-left: 912px; color: grey">Newest data appears first</h6>

                            <hr>

                            <!-- CUSTOMERS COUNT -->
                            <div class="text-center d-flex align-items-center justify-content-center" style="padding: 20px; border-radius: 15px;">

                                <div class="row col-4 justify-content-center" style="cursor: pointer;";>

                                    <?php
                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT COUNT(customer_ID) AS customerCount
                                                FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $customerCount = $result['customerCount'];
                                    ?>

                                    
                                    <div class="card border-0 fixed-width-element" id="count_card">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 120px; position: absolute; margin-top: -35px;"><?php echo $customerCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 100px;"
                                                >Total Customers</h6>
                                                <img src="icons/GIF_CUSTOMERS.gif" style="width: 1.2in; height: .7in; margin-left: 150px; margin-top: -15px;" id="customers_gif">

                                                <div style="position: absolute; margin-left: 1px; margin-top: 67px; width: 280px; line-height: 1.1;">
                                                    <?php
                                                        // Step 1: Get the count of total customers from tbl_customer_info
                                                        $sqlTotalCustomers = "SELECT COUNT(*) AS totalCustomers FROM tbl_customer_info";
                                                        $stmtTotalCustomers = $conn->prepare($sqlTotalCustomers);
                                                        $stmtTotalCustomers->execute();
                                                        $resultTotalCustomers = $stmtTotalCustomers->fetch(PDO::FETCH_ASSOC);
                                                        $totalCustomers = $resultTotalCustomers['totalCustomers'];

                                                        // Step 2: Get the count of feedback entries for today from tbl_feedback
                                                        $sqlFeedbackToday = "SELECT COUNT(DISTINCT customer_ID) AS feedbackCount FROM tbl_feedback WHERE DATE(date) = CURDATE()";
                                                        $stmtFeedbackToday = $conn->prepare($sqlFeedbackToday);
                                                        $stmtFeedbackToday->execute();
                                                        $resultFeedbackToday = $stmtFeedbackToday->fetch(PDO::FETCH_ASSOC);
                                                        $feedbackCountToday = $resultFeedbackToday['feedbackCount'];

                                                        // Display the result
                                                        // echo "$feedbackCountToday out of $totalCustomers customers sent us new feedbacks today.";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row col-3 justify-content-center";>
                                </div>
                                
                                <?php
                                    // Fetch customer data with their feedback and audio feedback counts
                                    $sqlCustomers = "
                                    SELECT 
                                        ci.customer_ID, 
                                        CONCAT('images/', ci.image) AS profilePicture, 
                                        CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS fullName,
                                        COUNT(DISTINCT fb.feedback_ID) AS feedbackCount,
                                        COUNT(DISTINCT af.audio_ID) AS audioFeedbackCount
                                    FROM tbl_customer_info AS ci
                                    LEFT JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                    LEFT JOIN tbl_audio_feedback AS af ON ci.customer_ID = af.customer_ID
                                    GROUP BY ci.customer_ID
                                    ORDER BY (COUNT(DISTINCT fb.feedback_ID) + COUNT(DISTINCT af.audio_ID)) DESC
                                    LIMIT 1";

                                    $stmtCustomers = $conn->prepare($sqlCustomers);
                                    $stmtCustomers->execute();
                                    $topCustomer = $stmtCustomers->fetch(PDO::FETCH_ASSOC);

                                    if ($topCustomer) {
                                        $customerID = $topCustomer['customer_ID'];
                                        $profilePicture = $topCustomer['profilePicture'];
                                        $fullName = $topCustomer['fullName'];
                                        $feedbackCount = $topCustomer['feedbackCount'];
                                        $audioFeedbackCount = $topCustomer['audioFeedbackCount'];
                                    } else {
                                        $topCustomer = null;
                                    }
                                ?>



                                <div class="row col-5" style="margin-top: -20px;">
                                    <div class="row text-center">
                                        <?php if ($topCustomer): ?>
                                            <!-- <a href="view_customer.php?customer_ID=<?php echo $customerID; ?>" class="customer-link" style="text-decoration: none; color: inherit; display: block;"> -->
                                            <a href="view_customer.php?customer_ID=<?php echo $customerID; ?>&top_customer=true" class="customer-link" style="text-decoration: none; color: inherit; display: block;">

                                                <h1>🏆</h1>
                                                <h4 class="text-danger" style="margin-top: -10px;">Top customer</h4>

                                                <div>
                                                    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="margin-top: -5px; width: 100px; height: 100px; border-radius: 50%; background-color: lightblue;">
                                                </div>

                                                <h3 style="margin-left: 0px; margin-top: -4px;"><?php echo $fullName; ?></h3>
                                                <h7 style="margin-left: 0px; margin-bottom: 0px; margin-top: -5px; color: gray;">Sent <?php echo $feedbackCount; ?> written feedbacks and <?php echo $audioFeedbackCount; ?> audio feedbacks</h7>
                                            </a>
                                        <?php else: ?>
                                            <h5>No top customer found</h5>
                                        <?php endif; ?>
                                    </div>
                                </div>




                            </div>
                            <!-- END CUSTOMERS COUNT -->






                            <!-- CUSTOMERS TABLE -->
                            <div class="text-center d-flex align-items-center justify-content-center" style="margin-left: 0px; padding: 20px; border-radius: 15px;">

                                <div class="row">
                                    <?php
                                        // Step 2: Fetch all data from tbl_customer_info with column aliases
                                        $sql = "SELECT CONCAT('images/', image) AS 'Profile picture',  -- Concatenate the image path with the 'image' column
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
                                        ORDER BY customer_ID DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table1">
                                        <table class="table table-bordered class alternate-row-table" id="list_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    if (!empty($customerData)) {
                                                        $aliasRow = $customerData[0]; // Assuming the first row contains aliases
                                                        foreach ($aliasRow as $alias => $value) {
                                                            echo "<th style='background-color: #cacbe8; color: black;'>$alias</th>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($customerData)) {
                                                    // Display the "No feedback yet for today" message in the table body
                                                    echo '<tr><td colspan="6" style="text-align: center; background-color: transparent; color: black;">No feedbacks yet for today</td></tr>';
                                                } else {
                                                    // Loop through the data and populate the table
                                                    foreach ($customerData as $row) {
                                                        // Check if the current row corresponds to the top customer
                                                        if ($row['Customer ID'] == $topCustomer['customer_ID']) {
                                                            // Display the trophy icon and other details for the top customer
                                                            echo "<tr class='customer-row' data-customer='" . json_encode($row) . "'>";
                                                            echo "<td><span style='position: relative;'><h1 style='font-size: 25px; position: absolute; left: -10px; top: -30px;'>🏆</h1><img src='" . $row['Profile picture'] . "' style='width: 80px; height: 80px; border: solid 0px lightblue; border-radius: 40px; background-color: lightblue;'></span></td>";
                                                            foreach ($row as $key => $value) {
                                                                if ($key !== 'Profile picture') {
                                                                    echo "<td>$value</td>";
                                                                }
                                                            }
                                                            echo "</tr>";
                                                        } else {
                                                            // Display other customers without the trophy icon
                                                            echo "<tr class='customer-row' data-customer='" . json_encode($row) . "'>";
                                                            foreach ($row as $key => $value) {
                                                                if ($key === 'Profile picture') {
                                                                    echo "<td><img src='$value' style='width: 80px; height: 80px; border: solid 0px lightblue; border-radius: 40px; background-color: lightblue;'></td>";
                                                                } else {
                                                                    echo "<td>$value</td>";
                                                                }
                                                            }
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!-- END CUSTOMERS TABLE -->


                            <!-- Modal -->
                            <div id="customerModal" class="custmodal">
                                <div class="custmodal-content">
                                    <span class="close">&times;</span>
                                    <div id="modalBody"></div>
                                    <!-- Add a button to view customer information -->
                                    <button id="viewAllBtn" class="view-all-btn">View Customer's Information</button>
                                </div>
                            </div>

                            <script>
                                // Get the custmodal
                                var custmodal = document.getElementById("customerModal");

                                // Get the <span> element that closes the custmodal
                                var span = document.getElementsByClassName("close")[0];

                                // When the user clicks on <span> (x), close the custmodal
                                span.onclick = function() {
                                    custmodal.style.display = "none";
                                };

                                // When the user clicks anywhere outside of the custmodal, close it
                                window.onclick = function(event) {
                                    if (event.target == custmodal) {
                                        custmodal.style.display = "none";
                                    }
                                };

                                // Add click event listener to each table row
                                document.querySelectorAll('.customer-row').forEach(function(row) {
                                    row.addEventListener('click', function() {
                                        var customerData = JSON.parse(this.getAttribute('data-customer'));
                                        var modalBody = document.getElementById("modalBody");
                                        var viewAllBtn = document.getElementById("viewAllBtn");

                                        // Clear previous content
                                        modalBody.innerHTML = '';

                                        // Populate custmodal with specific customer data
                                        if (customerData['Customer ID'] == <?php echo $topCustomer['customer_ID']; ?>) {
                                            modalBody.innerHTML += '<span style="position: relative;"><h1 style="position: absolute; left: -10px; top: -10px;">🏆</h1></span>';
                                        }
                                        modalBody.innerHTML += '<p><img src="' + customerData['Profile picture'] + '" style="width: 150px; height: 150px; background: lightblue; border-radius: 75px;"></p>';
                                        modalBody.innerHTML += '<p><strong>Full Name:</strong> ' + customerData['Firstname'] + ' ' + customerData['Middlename'] + ' ' + customerData['Lastname'] + '</p>';
                                        modalBody.innerHTML += '<p><strong>Address:</strong> ' + customerData['Street'] + ', ' + customerData['Barangay'] + ', ' + customerData['Municipality'] + ', ' + customerData['Province'] + ', ' + customerData['Zipcode'] + '</p>';
                                        modalBody.innerHTML += '<p><strong>Birth Date:</strong> ' + customerData['Birthdate'] + '</p>';
                                        modalBody.innerHTML += '<p><strong>Gender:</strong> ' + customerData['Gender'] + '</p>';
                                        modalBody.innerHTML += '<p><strong>Email:</strong> ' + customerData['Email'] + '</p>';
                                        modalBody.innerHTML += '<p><strong>Phone Number:</strong> ' + customerData['Phone Number'] + '</p>';
                                        
                                        // Add click event listener to "View Customer's Information" button
                                        viewAllBtn.onclick = function() {
                                            // Extract the customer ID from customerData
                                            var customerID = customerData['Customer ID'];
                                            // Check if the customer is the top customer
                                            var isTopCustomer = customerID == <?php echo $topCustomer['customer_ID']; ?>;
                                            // Construct the URL with customer ID and whether they are the top customer
                                            var url = 'view_customer.php?customer_ID=' + customerID + '&top_customer=' + isTopCustomer;
                                            // Redirect to view_customer.php with parameters
                                            window.location.href = url;
                                        };

                                        // Display the custmodal
                                        custmodal.style.display = "block";
                                    });
                                });
                            </script>

                            <style>

                                .customer-row:hover {
                                    background-color: #cacbe8 !important; /* A darker shade of light blue */
                                }

                                .table thead th {
                                    top: 0;
                                    z-index: 1;
                                    background-color: #c8e7c9;
                                    color: black;
                                }

                                .custmodal {
                                    display: none;
                                    position: fixed;
                                    z-index: 1;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                    height: 100%;
                                    overflow: hidden; /* Remove scrollbar */
                                    overflow-y: auto; /* Add scrollbar */
                                    background-color: rgba(0,0,0,0.4);
                                    padding-top: 60px;
                                }

                                .custmodal-content {
                                    background-color: #fefefe;
                                    margin: 5% auto;
                                    margin-top: 0px;
                                    padding: 20px;
                                    border: 1px solid #888;
                                    width: 30%;
                                }

                                .close {
                                    color: #aaa;
                                    float: right;
                                    font-size: 28px;
                                    font-weight: bold;
                                }

                                .close:hover,
                                .close:focus {
                                    color: black;
                                    text-decoration: none;
                                    cursor: pointer;
                                }

                                .view-all-btn {
                                    margin-top: 20px;
                                    padding: 10px 20px;
                                    background-color: #007bff; /* Primary Color */
                                    color: white;
                                    border: none;
                                    border-radius: 5px;
                                    cursor: pointer;
                                    text-align: center;
                                }

                                .view-all-btn:hover {
                                    background-color: #0056b3; /* Darkened Primary Color */
                                }
                            </style>

                            <script>
                                document.getElementById("count_card").addEventListener("click", function() {
                                    document.getElementById("table1").scrollIntoView({ behavior: "smooth" });
                                });
                            </script>

                            <hr>

                        </div>

                    </div>  <!-- END ROW 1 - ADMIN DASHBOARD - REPORTS -->

                    




                    <!-- </div> BODY END -->
                </div>
            </div>

        </div>
    </div>
    <!-- END ADMIN DASHBOARD -- FOR VIEWING ADMIN DASHBOARD -->




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
