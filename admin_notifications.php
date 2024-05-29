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
    <link rel="stylesheet" href="pages/admin_notifications/style_adnotifications.css">

    
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
                >Notifications</h5>
                <img src="icons/GIF_REPORT.gif" style="position: absolute; width: 2.15in; height: 1.1in; margin-left: 1150px; margin-top: 35px;" id="newfb_gif">

                <div class="container">
                
                    <!-- <div class="modal-body" id="dashbody" style="justify-content: center; background: yellow;">  BODY COLOR -->
                




                    <div class="row">
    <div class="card-body" id="cards_body2" style="justify-content: center; background: white;">
        <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">All notifications</h5>
        <h6 style="position: absolute; margin-top: -12px; margin-left: 912px; color: grey">Newest data appears first</h6>
        <hr>
        <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.5in; height: .9in; margin-left: 445px; margin-top: 0px;" id="adminnotif_gif">
        
        <style>
            .scrollable-content {
                height: 1000px;
                overflow-y: auto;
                color: black;
                background: white;
            }

            .notification-row {
                border: solid 1px lightblue;
                box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                border-radius: 5px;
                font-size: 20px;
                width: 900px;
                margin-left: 15px;
                margin-top: 10px;
                cursor: pointer; /* Add cursor pointer for better UX */
            }

            .notification-row.today {
                background-color: #ecffed;
            }

            .notification-row.today:hover {
                background-color: #d4f5d8;
            }

            .notification-row.yesterday {
                background-color: #f1e9e9;
            }

            .notification-row.yesterday:hover {
                background-color: #e0d3d3;
            }

            .notification-row.older {
                background-color: #ecedff;
            }

            .notification-row.older:hover {
                background-color: #d3d4f5;
            }

            /* Primary Button Style */
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

            /* Primary Button Hover Effect */
            .view-all-btn:hover {
                background-color: #0056b3; /* Darkened Primary Color */
            }

            /* Modal CSS */
            .notifmodal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: hidden; /* Remove scrollbar */
                background-color: rgba(0,0,0,0.4);
                padding-top: 60px;
            }

            .notifmodal-content {
                background-color: #fefefe;
                margin: 5% auto;
                margin-top: 0px;
                padding: 20px;
                border: 1px solid #888;
                width: 30%;
                max-height: 100%; /* Set a maximum height for the notifmodal */
                overflow-y: auto; /* Add vertical scrollbar when content overflows */
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
        </style>

        <!-- NOTIFICATIONS TABLE -->
        <div class="scrollable-content" id="inputfields">
            <div style="position: relative;">
                <?php
                // Database connection
                // Assuming you have already established a connection to the database using $conn

                // Fetch and display customer activities from tbl_activity_logs
                $sqlNotifications = "
SELECT 
    al.activity_ID,
    al.feedback_ID,  -- Add feedback_ID to the SELECT statement
    al.audio_ID,     -- Add audio_ID to the SELECT statement
    ci.customer_id,
    CONCAT('images/', ci.image) AS image,
    CONCAT(ci.firstName, ' ', ci.middlename, ' ', ci.lastName) AS name,
    ci.gender,
    al.dateAdded AS date,
    al.activity AS type
FROM 
    tbl_activity_logs al
JOIN 
    tbl_customer_info ci ON al.customer_id = ci.customer_id
WHERE 
    al.activity IN ('Registered an account', 'Sent feedback', 'Sent audio feedback')
ORDER BY 
    al.dateAdded DESC";



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

                // Function to display notifications
                function displayNotifications($notifications, $heading, $class) {
                    echo '<h4 style="margin-top: 20px; margin-left: 15px; font-size: 20px; color: gray;">' . $heading . '</h4>';
                
                    if (empty($notifications)) {
                        echo '<p style="margin-left: 15px; font-size: 18px; color: gray;">No notifications ' . strtolower($heading) . '.</p>';
                    } else {
                        foreach ($notifications as $notification) {
                            $notificationData = htmlspecialchars(json_encode($notification), ENT_QUOTES, 'UTF-8');
                            echo '<div class="row notification-row ' . $class . '" data-notification=\'' . $notificationData . '\' style="border: solid 1px lightblue; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166); 
                                border-radius: 5px; font-size: 20px; width: 900px; margin-left: 15px; margin-top: 10px;">';
                
                            echo '<div class="col-auto">
                                    <img src="' . htmlspecialchars($notification['image']) . '" style="width: 60px; height: 60px; border-radius: 30px; background-color: white; margin-top: 12px;">
                                </div>';
                            echo '<div class="col">
                                    <p style="margin-top: 10px;"><strong>' . htmlspecialchars($notification['name']) . '</strong> ' . getActivityMessage($notification['type'], $notification['gender']) . '</p>
                                    <p style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['date'], $heading) . '</p>
                                </div>';
                            echo '</div>';
                        }
                    }
                }
                

                // Function to return activity message based on the type and gender
                function getActivityMessage($type, $gender) {
                    $pronoun = ($gender == 'Male') ? 'his' : (($gender == 'Female') ? 'her' : 'his/her');

                    switch ($type) {
                        case 'Registered an account':
                            return 'has registered an account.';
                        case 'Sent feedback':
                            return 'has submitted feedback.';
                        case 'Updated the profile':
                            return 'has updated ' . $pronoun . ' profile.';
                        case 'Changed Profile Picture':
                            return 'has changed ' . $pronoun . ' profile picture.';
                        case 'Sent audio feedback':
                            return 'has submitted an audio feedback.';
                        default:
                            return '';
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

                // Display "Today" notifications
                displayNotifications($todayNotifications, 'Today', 'today');

                // Display "Yesterday" notifications
                displayNotifications($yesterdayNotifications, 'Yesterday', 'yesterday');

                // Display "Older" notifications
                displayNotifications($olderNotifications, 'Older', 'older');
                ?>
            </div>
        </div>
        <!-- END NOTIFICATIONS TABLE -->

        <hr>

        <!-- Modal -->
        <div id="notificationModal" class="notifmodal">
            <div class="notifmodal-content">
                <span class="close">&times;</span>
                <div id="notificationModalBody"></div>
                <button id="viewNotificationBtn" class="view-all-btn">View Customer's Information</button>
            </div>
        </div>

        <!-- JavaScript for Modal Functionality -->
        <script>
            // JavaScript for Modal Functionality
            var notifmodal = document.getElementById("notificationModal");
            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() {
                notifmodal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == notifmodal) {
                    notifmodal.style.display = "none";
                }
            }

            document.querySelectorAll('.notification-row').forEach(function(row) {
                row.addEventListener('click', function() {
                    var notificationData = JSON.parse(this.getAttribute('data-notification'));
                    var modalBody = document.getElementById("notificationModalBody");
                    var viewNotificationBtn = document.getElementById("viewNotificationBtn");

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "fetch_modal_data.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);

                            modalBody.innerHTML = '';
                            // modalBody.innerHTML += '<p><strong>Activity ID:</strong> ' + notificationData.activity_ID + '</p>';
                            // modalBody.innerHTML += '<p><strong>Feedback ID:</strong> ' + notificationData.feedback_ID + '</p>'; // Display Feedback ID
                            // modalBody.innerHTML += '<p><strong>Audio ID:</strong> ' + notificationData.audio_ID + '</p>'; // Display Audio ID

                            if (notificationData['type'] === 'Sent feedback') {
                                // Display feedback details
                                modalBody.innerHTML += '<p><img src="' + response['Profile picture'] + '" style="width: 150px; height: 150px; border-radius: 75px;"></p>';
                                modalBody.innerHTML += '<h4><strong></strong> ' + response['Full Name'] + '</h4>';
                                modalBody.innerHTML += '<p><strong>Products:</strong> ' + response['Products'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Services:</strong> ' + response['Services'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Convenience:</strong> ' + response['Convenience'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Rating:</strong> ' + response['Rating'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Date:</strong> ' + response['Date'] + '</p>';
                            } else if (notificationData['type'] === 'Sent audio feedback') {
                                // Display audio feedback details
                                modalBody.innerHTML += '<p><img src="' + response['Profile picture'] + '" style="width: 150px; height: 150px; border-radius: 75px;"></p>';
                                modalBody.innerHTML += '<h4><strong></strong> ' + response['Full Name'] + '</h4>';
                                modalBody.innerHTML += '<p><strong></strong><audio controls><source src="http://localhost/nasara/audios/' + response['Audio'] + '" type="audio/mpeg">Your browser does not support the audio element.</audio></p>';
                                modalBody.innerHTML += '<p><strong>Date:</strong> ' + response['Date'] + '</p>';
                            } else if (notificationData['type'] === 'Registered an account') {
                                // Display account registration details
                                modalBody.innerHTML += '<p><img src="' + response['Profile picture'] + '" style="width: 150px; height: 150px; border-radius: 75px;"></p>';
                                modalBody.innerHTML += '<h4><strong>Name:</strong> ' + response['Firstname'] + ' ' + response['Middlename'] + ' ' + response['Lastname'] + '</h4>';
                                modalBody.innerHTML += '<p><strong>Address:</strong> ' + response['Street'] + ', ' + response['Barangay'] + ', ' + response['Municipality'] + ', ' + response['Province'] + ' - ' + response['Zipcode'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Phone Number:</strong> ' + response['Phone Number'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Birthdate:</strong> ' + response['Birthdate'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Gender:</strong> ' + response['Gender'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Email:</strong> ' + response['Email'] + '</p>';
                                modalBody.innerHTML += '<p><strong>Creation Date:</strong> ' + response['Creation Date'] + '</p>';
                            }

                            viewNotificationBtn.onclick = function() {
                                window.location.href = 'view_customer.php?customer_ID=' + response['Customer ID'];
                            };

                            notifmodal.style.display = "block";

                        }
                    };
                    xhr.send("customer_id=" + notificationData['customer_id'] + "&type=" + notificationData['type'] + "&feedback_ID=" + notificationData['feedback_ID'] + "&audio_ID=" + notificationData['audio_ID']);

                });
            });

        </script>




    </div>
</div>




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
