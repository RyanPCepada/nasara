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
    <link rel="stylesheet" href="pages/admin_feedbacks/style_adfeedbacks.css">

    
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

        



        <div class="col-11">

            <div class="body">
            
                <h5 style="position: absolute; margin-top: 40px; margin-bottom: 25px; margin-left: 210px; font-size: 70px; color: gray;"
                >Feedbacks</h5>
                
                <img src="icons/GIF_REPORT.gif" style="position: absolute; width: 2.15in; height: 1.1in; margin-left: 1150px; margin-top: 35px;" id="newfb_gif">

                <div class="container">
                
                    <!-- <div class="modal-body" id="dashbody" style="justify-content: center; background: yellow;">  BODY COLOR -->
                




                    <div class="row">

                        <div class="card-body" id="cards_body2" style="justify-content: center; background: white;">
                        
                            <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">Feedbacks list</h5>
                            
                            <h6 style="position: absolute; margin-top: -12px; margin-left: 912px; color: grey">Newest data appears first</h6>

                            <hr>

                            <!-- FEEDBACKS COUNT -->
                            <div class="text-center d-flex align-items-center justify-content-center" style="padding: 20px; border-radius: 15px;">
                                <div class="row justify-content-center">
                                    <?php
                                    // Fetch count of written feedbacks from tbl_feedback
                                    $sqlWrittenFeedbacks = "SELECT COUNT(feedback_ID) AS writtenFeedbacks FROM tbl_feedback";
                                    $stmtWrittenFeedbacks = $conn->prepare($sqlWrittenFeedbacks);
                                    $stmtWrittenFeedbacks->execute();
                                    $writtenFeedbacks = $stmtWrittenFeedbacks->fetch(PDO::FETCH_ASSOC)['writtenFeedbacks'];

                                    // Fetch count of audio feedbacks from tbl_audio_feedback
                                    $sqlAudioFeedbacks = "SELECT COUNT(audio_ID) AS audioFeedbacks FROM tbl_audio_feedback";
                                    $stmtAudioFeedbacks = $conn->prepare($sqlAudioFeedbacks);
                                    $stmtAudioFeedbacks->execute();
                                    $audioFeedbacks = $stmtAudioFeedbacks->fetch(PDO::FETCH_ASSOC)['audioFeedbacks'];

                                    // Calculate total feedback count
                                    $totalFeedbacks = $writtenFeedbacks + $audioFeedbacks;
                                    ?>
                                    <div class="card border-0 fixed-width-element" id="count_card" style="cursor: pointer;">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title" style="font-size: 120px; position: absolute; margin-top: -35px;"><?php echo $totalFeedbacks; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 100px;">Total Feedbacks</h6>
                                                <img src="icons/GIF_NEWFB.gif" style="width: 1.4in; height: .80in; margin-left: 135px; margin-top: -27px;" id="newfb_gif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center d-flex align-items-center justify-content-center" style="margin-top: 0px;">
                                <img src="icons/GIF_WRITTEN_WHITE_BG.gif" id="gif_written_white_bg" style="width: .8in; height: .80in; margin-left: 0px; margin-top: 0px; cursor: pointer;">
                                <?php
                                    echo '<h2 id="count_written_fb" style="cursor: pointer;">' . $writtenFeedbacks . '</h2>';
                                ?>
                                <div style="margin: 20px;"></div>
                                <img src="icons/GIF_MIC_WHITE_BG.gif" id="gif_mic_white_bg" style="width: .8in; height: .80in; margin-left: 0px; margin-top: 0px; cursor: pointer;">
                                <?php
                                    echo '<h2 id="count_audio_fb" style="cursor: pointer;">' . $audioFeedbacks . '</h2>';
                                ?>
                            </div>
                            <!-- END FEEDBACKS COUNT -->

                        </div>

                    </div>  <!-- END ROW 1 - ADMIN DASHBOARD - REPORTS -->
































                    <div class="row">

                        <div class="card-body" id="cards_body3" style="justify-content: center; background: white;">


                            <!-- CSS for Hover Effect -->
                            <style>
                                .table-hover tbody tr:hover {
                                    background-color: #c8e7c9 !important;
                                }

                                .fbmodal {
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

                                .fbmodal-content {
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
                            </style>


                            <div class="text-center d-flex align-items-center justify-content-center" style="margin-left: 0px; padding: 20px; border-radius: 15px;">
                                <div class="row" id="div_written_fb">
                                    <h3 style="margin-top: 10px; margin-bottom: 40px; margin-left: -405px; color: gray;">Written Feedbacks</h3>
                                    <?php
                                        // Step 2: Fetch data from tbl_customer_info
                                        $sql = "SELECT
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
                                        ORDER BY fb.feedback_ID DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table_written_fb">
                                        <table class="table table-bordered table-hover class alternate-row-table" id="list_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    if (!empty($customerData)) {
                                                        $aliasRow = $customerData[0]; // Assuming the first row contains aliases
                                                        foreach ($aliasRow as $alias => $value) {
                                                            echo "<th style='background-color: #c8e7c9; color: black;'>$alias</th>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($customerData)) {
                                                    // Display the "No feedback yet for today" message in the table body
                                                    echo '<tr><td colspan="8" style="text-align: center; background-color: transparent; color: black;">No feedbacks yet for today</td></tr>';
                                                } else {
                                                    // Loop through the data and populate the table
                                                    foreach ($customerData as $row) {
                                                        echo "<tr data-customer='" . json_encode($row) . "'>";
                                                        foreach ($row as $key => $value) {
                                                            if ($key === 'Profile picture') {
                                                                echo "<td><img src='$value' style='width: 80px; height: 80px; border: solid 0px lightblue; border-radius: 40px; background-color: white;'></td>";
                                                            } else {
                                                                echo "<td>$value</td>";
                                                            }
                                                        }
                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div id="customerModal" class="fbmodal">
                                <div class="fbmodal-content">
                                    <span class="close">&times;</span>
                                    <div id="modalBody"></div>
                                    <button id="viewAllBtn" class="view-all-btn">View Customer's Information</button>
                                </div>
                            </div>

                            <!-- JavaScript for Modal Functionality -->
                            <script>
                                // Get the fbmodal
                                var fbmodal = document.getElementById("customerModal");

                                // Get the <span> element that closes the fbmodal
                                var span = document.getElementsByClassName("close")[0];

                                // When the user clicks on <span> (x), close the fbmodal
                                span.onclick = function() {
                                    fbmodal.style.display = "none";
                                }

                                // When the user clicks anywhere outside of the fbmodal, close it
                                window.onclick = function(event) {
                                    if (event.target == fbmodal) {
                                        fbmodal.style.display = "none";
                                    }
                                }

                                // Add click event listener to each table row
                                document.querySelectorAll('#list_table tbody tr').forEach(function(row) {
                                    row.addEventListener('click', function() {
                                        var customerData = JSON.parse(this.getAttribute('data-customer'));
                                        var modalBody = document.getElementById("modalBody");
                                        var viewAllBtn = document.getElementById("viewAllBtn");

                                        // Clear previous content
                                        modalBody.innerHTML = '';

                                        // Populate modal with customer data
                                        for (var key in customerData) {
                                            if (key === 'Profile picture') {
                                                modalBody.innerHTML += '<p><img src="' + customerData[key] + '" style="width: 150px; height: 150px; border-radius: 75px;"></p>';
                                            } else {
                                                modalBody.innerHTML += '<p><strong>' + key + ':</strong> ' + customerData[key] + '</p>';
                                            }
                                        }

                                        // Set the link for the view all button
                                        viewAllBtn.onclick = function() {
                                            // Extract the customer ID from customerData
                                            var customerID = customerData['Customer ID'];
                                            // Redirect to view_customer.php with customer ID parameter
                                            window.location.href = 'view_customer.php?customer_ID=' + customerID;
                                        };

                                        // Display the fbmodal
                                        fbmodal.style.display = "block";
                                    });
                                });
                            </script>


                        </div>

                    </div>  <!-- END ROW 1 - ADMIN DASHBOARD - REPORTS -->





                    <div class="row">

                        <div class="card-body" id="cards_body4" style="justify-content: center; background: white;">

                            <style>
                                .customer-name {
                                    cursor: pointer;
                                    text-decoration: none;
                                    transition: text-decoration 0.3s ease;
                                    color: black; /* Set the color to black */
                                }

                                .customer-name:hover {
                                    text-decoration: underline;
                                    color: black;
                                }

                                .profile-image {
                                    transition: transform 0.3s ease;
                                }

                                .profile-image:hover {
                                    transform: scale(1.05);
                                    border: solid 2px white !important;
                                }
                            </style>


                            <!-- AUDIO FEEDBACKS TABLE -->
                            <div class="card-body" id="div_audio_fb" style="position: relative; justify-content: center; background: white; margin-top: 0px;">

                                <h3 style="margin: 20px; color: gray;">Audio Feedbacks</h3>

                                <!-- <hr> -->

                                <div class="scrollable-content" id="table_audio_fb">
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
                                        ORDER BY af.audio_ID DESC";

                                    $stmtAudios = $conn->prepare($sqlAudios);
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
                                                // Wrap the image with an anchor tag
                                                echo '<a href="view_customer.php?customer_ID=' . $audio['Customer ID'] . '"><img class="profile-image" src="' . htmlspecialchars($audio['Profile picture']) . '" alt="Profile picture" style="width: 80px; height: 80px; border: solid 0px lightblue; border-radius: 50%; background-color: white;"></a>';
                                                echo '</div>';
                                        
                                                echo '<div class="col">';
                                                echo '<p style="margin-top: 10px; font-weight: bold;"><a href="view_customer.php?customer_ID=' . $audio['Customer ID'] . '" class="customer-name">' . htmlspecialchars($audio['Full Name']) . '</a></p>';
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




                        </div>

                    </div>  <!-- END ROW 1 - ADMIN DASHBOARD - REPORTS -->




















                    




                    <!-- </div> BODY END -->
                </div>
            </div>

        </div>
    </div>
    <!-- END ADMIN DASHBOARD -- FOR VIEWING ADMIN DASHBOARD -->

    
    <script>
        document.getElementById("count_card").addEventListener("click", function() {
            // Scroll to the audio feedbacks table first
            document.getElementById("table_audio_fb").scrollIntoView({ behavior: "smooth" });
            
            // Delay scrolling to the written feedbacks table
            setTimeout(function() {
                document.getElementById("div_written_fb").scrollIntoView({ behavior: "smooth", block: "start" });
            }, 800); // Adjust the delay time as needed
        });

        document.getElementById("gif_written_white_bg").addEventListener("click", function() {
        document.getElementById("div_written_fb").scrollIntoView({ behavior: "smooth" });
        });
        
        document.getElementById("count_written_fb").addEventListener("click", function() {
        document.getElementById("div_written_fb").scrollIntoView({ behavior: "smooth" });
        });

        document.getElementById("gif_mic_white_bg").addEventListener("click", function() {
        document.getElementById("div_audio_fb").scrollIntoView({ behavior: "smooth" });
        });

        document.getElementById("count_audio_fb").addEventListener("click", function() {
        document.getElementById("div_audio_fb").scrollIntoView({ behavior: "smooth" });
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
