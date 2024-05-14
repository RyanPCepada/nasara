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
    <link rel="stylesheet" href="pages/admin/style_ad.css">

    
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">

        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">

        

    </nav>








    <!-- ADMIN DASHBOARD - FOR VIEWING ADMIN DASHBOARD -->
    <div class="row" id="dash_bg">

        <div class="col-1">
            <div class="card-body text-center d-flex justify-content-center" id="cards_body1">

                <div class="text-center d-flex align-items-center justify-content-center bg-dark" id="div_home"></div>
                <button class="btn btn-secondary" type="button" id="icon_home" onclick="to_home()" href="home_main.php">
                    <i class="fas fa-home"></i>
                    <h3 style="margin-top: -39px; margin-left: 52px;">Home</h3>
                </button>

                <button class="btn btn-secondary" type="button" id="icon_settings" data-bs-toggle="modal" data-bs-target="#modal_settings">
                    <i class="fas fa-cog"></i>
                    <h3 style="margin-top: -39px; margin-left: 52px;">Settings</h3>
                </button>
                
                <button class="btn btn-secondary" type="button" id="icon_history" data-bs-toggle="modal" data-bs-target="#modal_history">
                    <i class="fas fa-history"></i>
                    <h3 style="margin-top: -39px; margin-left: 52px;">History</h3>
                </button>

                <img src="images/<?php echo $adminimage; ?>" id="icon_account" class="img-fluid zoomable-image rounded-square"
                onclick="to_adminacc()">

                <h3 style="color: white; margin-top: 311px; margin-left: 13px;">Me</h3>

                <div class = " m-2 text-light" >   
                    <b class = "bg-transparent "  id="accountLink" onclick="to_account()" style=" cursor: pointer;"> <img src="navigation/user.png" alt=""></b>
                </div>

            </div>
        </div>













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

    




















        <div class="col-11">

            <div class="body">
            
                <h5 style="position: absolute; margin-top: 40px; margin-bottom: 25px; margin-left: 140px; font-size: 70px; color: gray;"
                >Dashboard</h5>
                <img src="icons/GIF_REPORT.gif" style="position: absolute; width: 2.15in; height: 1.1in; margin-left: 480px; margin-top: 35px;" id="newfb_gif">

                <div class="container">
                
                    <!-- <div class="modal-body" id="dashbody" style="justify-content: center; background: yellow;">  BODY COLOR -->
                




                    <div class="row"> <!-- ROW 1 - ADMIN DASHBOARD - REPORTS -->

                        <div class="card-body" id="cards_body2" style="justify-content: center; background: white;"> <!--BLUE-->
                        
                            <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">Today's data</h5>
                            
                            <h6 style="position: absolute; margin-top: -12px; margin-left: 960px; color: grey">Newest data appears first</h6>

                            <hr>

                            <!-- ROW 1 -->
                            <div class="" style="padding: 20px; border-radius: 15px;">

                                <div class="col-4 justify-content-center";>

                                    <?php
                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT COUNT(feedback_ID) AS feedbackCount
                                                FROM tbl_feedback WHERE DATE(date) = CURDATE()";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackCount = $result['feedbackCount'];
                                    ?>
                                    
                                    <div class="card border-0 fixed-width-element" id="card1">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >New Feedbacks</h6>
                                                <img src="icons/GIF_NEWFB.gif" style="width: 1.4in; height: .80in; margin-left: 142px; margin-top: -27px;" id="newfb_gif">

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
                                                        echo "$feedbackCountToday out of $totalCustomers customers sent us new feedbacks today.";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">
                                    <?php
                                    $sql = "SELECT * FROM tbl_customer_info";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    $sql = "SELECT
                                        CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer',
                                        fb.opinion AS 'Opinion',
                                        fb.suggestion AS 'Suggestion',
                                        fb.question AS 'Question',
                                        fb.rating AS 'Rating',
                                        fb.date AS 'Date'
                                    FROM tbl_customer_info AS ci
                                    JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                    WHERE DATE(date) = CURDATE()
                                    ORDER BY date DESC";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table1">
                                        <table class="table table-bordered class alternate-row-table" id="card1_table">
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
                                                    echo '<tr><td colspan="6" style="text-align: center; background-color: transparent; color: black;"
                                                    >No feedbacks yet for today</td></tr>';
                                                } else {
                                                    // Loop through the data and populate the table
                                                    foreach ($customerData as $row) {
                                                        echo "<tr>";
                                                        foreach ($row as $value) {
                                                            echo "<td>$value</td>";
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
                            <!-- END ROW 1 -->

                            <hr>

                            <!-- END ROW 2 -->
                            <div class="" style="padding: 20px;"> <!-- ROW 2 -->  

                                <div class="col-4 justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_customer_info with column aliases
                                        $sql = "SELECT COUNT(feedback_ID) AS feedbackCount FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackCount = $result['feedbackCount'];
                                    ?>
                                    
                                    <div class="card border-0 fixed-width-element" id="card2">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >Total Feedbacks</h6>
                                                <img src="icons/GIF_TOTALFB.gif" style="width: 1.5in; height: .80in; margin-left: 130px; margin-top: -20px;" id="totalfb_gif">
                                                
                                                <div style="position: absolute; margin-left: 1px; margin-top: 60px; width: 280px; line-height: 1.1;">
                                                    <?php
                                                        // Step 1: Get the count of total customers from tbl_customer_info
                                                        $sqlTotalCustomers = "SELECT COUNT(*) AS totalCustomers FROM tbl_customer_info";
                                                        $stmtTotalCustomers = $conn->prepare($sqlTotalCustomers);
                                                        $stmtTotalCustomers->execute();
                                                        $resultTotalCustomers = $stmtTotalCustomers->fetch(PDO::FETCH_ASSOC);
                                                        $totalCustomers = $resultTotalCustomers['totalCustomers'];

                                                        // Step 2: Get the count of distinct customer IDs who sent feedback today from tbl_feedback
                                                        $sqlFeedbackToday = "SELECT COUNT(DISTINCT customer_ID) AS feedbackCount FROM tbl_feedback";
                                                        $stmtFeedbackToday = $conn->prepare($sqlFeedbackToday);
                                                        $stmtFeedbackToday->execute();
                                                        $resultFeedbackToday = $stmtFeedbackToday->fetch(PDO::FETCH_ASSOC);
                                                        $feedbackCountToday = $resultFeedbackToday['feedbackCount'];

                                                        // Display the result
                                                        echo "$feedbackCountToday out of $totalCustomers customers sent us feedbacks.";
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            fb.opinion AS 'Opinion',
                                            fb.suggestion AS 'Suggestion',
                                            fb.question AS 'Question',
                                            fb.rating AS 'Rating',
                                            fb.date AS 'Date',
                                            CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer'
                                        FROM tbl_customer_info AS ci
                                        JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                        ORDER BY date DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table2"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card2_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #d0c9e8; color: black;'>$alias</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the data and populate the table
                                                foreach ($customerData as $row) {
                                                    echo "<tr>";
                                                    foreach ($row as $value) {
                                                        echo "<td>$value</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!-- END ROW 2 -->

                            <hr>

                            <!-- ROW 3 -->
                            <div class="" style="padding: 20px;"> <!-- RED -->  

                                <div class="col-4 justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_feedback with column aliases
                                        $sql = "SELECT feedbackDate, ROUND(AVG(feedbackCount), 1) AS feedbackAverage
                                        FROM (
                                            SELECT DATE(date) AS feedbackDate, COUNT(*) AS feedbackCount
                                            FROM tbl_feedback
                                            GROUP BY DATE(date)
                                        ) AS subquery";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();


                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackAverage = $result['feedbackAverage'];
                                    ?>
                                    
                                    <div class="card border-0 fixed-width-element" id="card3">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackAverage; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >Feedbacks a day</h6>
                                                <img src="icons/GIF_FBPERDAY.gif" style="width: 1.4in; height: .85in; margin-left: 142px; margin-top: -20px;" id="fbperday_gif">

                                                <div style="position: absolute; margin-left: 1px; margin-top: 56px; width: 280px; line-height: 1.1;">
                                                <?php
                                                    // Step 1: Get the average feedback count for the past days
                                                    $sqlFeedbackPast = "SELECT AVG(feedbackCount) AS averageFeedbackCountPast FROM (
                                                        SELECT COUNT(*) AS feedbackCount FROM tbl_feedback
                                                        WHERE DATE(date) < CURDATE()
                                                        GROUP BY DATE(date)
                                                    ) AS subquery";
                                                    $stmtFeedbackPast = $conn->prepare($sqlFeedbackPast);
                                                    $stmtFeedbackPast->execute();
                                                    $resultFeedbackPast = $stmtFeedbackPast->fetch(PDO::FETCH_ASSOC);
                                                    $averageFeedbackCountPast = $resultFeedbackPast['averageFeedbackCountPast'];

                                                    // Step 2: Get the feedback count for today
                                                    $sqlFeedbackToday = "SELECT AVG(feedbackCount) AS averageFeedbackCountToday FROM (
                                                        SELECT COUNT(*) AS feedbackCount FROM tbl_feedback
                                                        GROUP BY DATE(date)
                                                    ) AS subquery";
                                                    $stmtFeedbackToday = $conn->prepare($sqlFeedbackToday);
                                                    $stmtFeedbackToday->execute();
                                                    $resultFeedbackToday = $stmtFeedbackToday->fetch(PDO::FETCH_ASSOC);
                                                    $averageFeedbackCountToday = $resultFeedbackToday['averageFeedbackCountToday'];

                                                    // Calculate the improvement as today's feedback count divided by past average
                                                    $improvementPercentage = ($averageFeedbackCountToday / $averageFeedbackCountPast);

                                                    // Format the percentage with two decimal places
                                                    $formattedImprovementPercentage = number_format($improvementPercentage, 2);

                                                    // Display the result
                                                    echo "We are " . $formattedImprovementPercentage . " times improved compared to the previous days.";
                                                ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            COUNT(feedback_ID) AS 'Number of Feedbacks',
                                            DATE(date) AS 'Date'
                                        FROM tbl_feedback
                                        GROUP BY DATE(date) DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table3"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card3_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #e3c8c8; color: black;'>$alias</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the data and populate the table
                                                foreach ($customerData as $row) {
                                                    echo "<tr>";
                                                    foreach ($row as $value) {
                                                        echo "<td>$value</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <!-- END ROW 3 -->

                            <hr>

                            <!-- ROW 4 -->
                            <div class="" style="padding: 20px;"> <!-- RED -->  

                                <div class="col-4 justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_customer_info with column aliases
                                        $sql = "SELECT COUNT(customer_ID) AS customerCount FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $customerCount = $result['customerCount'];
                                    ?>
                                    
                                    <div class="card border-0 fixed-width-element" id="card4">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $customerCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >Customers</h6>
                                                <img src="icons/GIF_CUSTOMERS.gif" style="width: 1.2in; height: .7in; margin-left: 160px; margin-top: -15px;" id="customers_gif">
                                                    
                                                    <div style="position: absolute; margin-left: 1px; margin-top: 65px; width: 280px; line-height: 1.1;">
                                                        <?php
                                                            // Calculate the number of new customers for the past 3 days
                                                            $sqlNewCustomers = "SELECT COUNT(*) AS newCustomers FROM tbl_customer_info WHERE DATE(dateAdded) BETWEEN CURDATE() - INTERVAL 3 DAY AND CURDATE()";
                                                            $stmtNewCustomers = $conn->prepare($sqlNewCustomers);
                                                            $stmtNewCustomers->execute();
                                                            $resultNewCustomers = $stmtNewCustomers->fetch(PDO::FETCH_ASSOC);
                                                            $newCustomers = $resultNewCustomers['newCustomers'];

                                                            // Display the result
                                                            echo "We have gained $newCustomers new customers for the past 3 days.";
                                                        ?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            ci.customer_ID AS 'ID',
                                            CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer',
                                            ci.dateAdded AS 'Registration Date'
                                        FROM tbl_customer_info AS ci
                                        ORDER BY customer_ID DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table4"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card4_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #cacbe8; color: black;'>$alias</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the data and populate the table
                                                foreach ($customerData as $row) {
                                                    echo "<tr>";
                                                    foreach ($row as $value) {
                                                        echo "<td>$value</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                
                            </div>

                            <!-- END ROW 4 -->

                            <hr>

                            <!-- ROW 5 -->
                            <div class="" style="padding: 20px;"> <!-- GREEN COLOR -->

                                <div class="col-4 justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_feedback with column aliases
                                        $sql = "SELECT COUNT(*) AS ratingCount
                                            FROM tbl_feedback WHERE rating = 5;";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $ratingCount = $result['ratingCount'];
                                    ?>
                                    
                                    <div class="card border-0 fixed-width-element" id="card5">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $ratingCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >5&#9733; Rating</h6>
                                                <img src="icons/GIF_RATING.gif" style="width: 1.65in; height: .90in; margin-left: 115px; margin-top: -20px;" id="rating_gif">
                                                
                                                <div style="position: absolute; margin-left: 1px; margin-top: 50px; width: 280px; line-height: 1.1;">
                                                    <?php
                                                        // Step 1: Get the count of all feedback entries
                                                        $sqlTotalFeedback = "SELECT COUNT(*) AS totalFeedback FROM tbl_feedback";
                                                        $stmtTotalFeedback = $conn->prepare($sqlTotalFeedback);
                                                        $stmtTotalFeedback->execute();
                                                        $resultTotalFeedback = $stmtTotalFeedback->fetch(PDO::FETCH_ASSOC);
                                                        $totalFeedback = $resultTotalFeedback['totalFeedback'];

                                                        // Step 2: Get the count of feedback entries rated with 5 stars
                                                        $sqlFeedbackWithFiveStars = "SELECT COUNT(*) AS feedbackCount FROM tbl_feedback WHERE rating = 5";
                                                        $stmtFeedbackWithFiveStars = $conn->prepare($sqlFeedbackWithFiveStars);
                                                        $stmtFeedbackWithFiveStars->execute();
                                                        $resultFeedbackWithFiveStars = $stmtFeedbackWithFiveStars->fetch(PDO::FETCH_ASSOC);
                                                        $feedbackCountWithFiveStars = $resultFeedbackWithFiveStars['feedbackCount'];

                                                        // Calculate the percentage of feedbacks rated with 5 stars
                                                        if ($totalFeedback > 0) {
                                                            $percentage = ($feedbackCountWithFiveStars / $totalFeedback) * 100;
                                                        } else {
                                                            $percentage = 0;
                                                        }

                                                        // Format the percentage with two decimal places
                                                        $formattedPercentage = number_format($percentage, 2);

                                                        // Display the result
                                                        echo "$formattedPercentage% of feedbacks rated us with 5 stars.";
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            fb.rating AS 'Rating',
                                            CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer',
                                            fb.date AS 'Date'
                                        FROM tbl_customer_info AS ci
                                        JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                        WHERE rating = 5
                                        ORDER BY date DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table5"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card5_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #dcddc7; color: black;'>$alias</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the data and populate the table
                                                foreach ($customerData as $row) {
                                                    echo "<tr>";
                                                    foreach ($row as $value) {
                                                        echo "<td>$value</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                            <hr>

                        </div> <!--BLUE-->

                    </div>  <!-- END ROW 1 - ADMIN DASHBOARD - REPORTS -->

                    





                    <div class="row"> <!-- ROW 2 - ADMIN DASHBOARD - LINE CHART -->

                        <div class="card-body" id="cards_body3" style="justify-content: center; background: white;"> <!--BLUE-->
                        
                            <div class="row">
                                
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-6" style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">
                                        <h5>Line Chart</h5>
                                    </div>
                                    <div class="col-6">
                                        <h5></h5>
                                    </div>
                                    <hr>
                                </div>


                                <div class="row">

                                    <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <?php
                                            $sql = "SELECT DATE(date) as day, COUNT(*) as feedbackCount
                                                    FROM tbl_feedback
                                                    GROUP BY DATE(date)
                                                    ORDER BY DATE(date)";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $days = [];
                                            $feedbackCounts = [];

                                            foreach ($result as $row) {
                                                $days[] = $row['day'];
                                                $feedbackCounts[] = $row['feedbackCount'];
                                            }
                                        ?>

                                        <script>
                                            var days = <?php echo json_encode($days); ?>;
                                            var feedbackCounts = <?php echo json_encode($feedbackCounts); ?>;
                                        </script>



                                        <div style="width: 500px; margin: 0 auto;">
                                            <canvas id="LineChart1"></canvas>
                                        </div>

                                        <script>
                                            var ctx = document.getElementById('LineChart1').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: days,
                                                    datasets: [{
                                                        label: 'Feedbacks per Day',
                                                        data: feedbackCounts,
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 1,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: false,
                                                            position: 'bottom' // or 'top', 'left', 'right' based on your preference
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Feedbacks per Day</h5>

                                    </div>



                                    <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <?php
                                            $sql = "SELECT DATE(dateAdded) as day, COUNT(*) as customerCount
                                                    FROM tbl_customer_info
                                                    GROUP BY DATE(dateAdded)
                                                    ORDER BY DATE(dateAdded)";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $days = [];
                                            $customerCounts = [];

                                            foreach ($result as $row) {
                                                $days[] = $row['day'];
                                                $customerCounts[] = $row['customerCount'];
                                            }
                                        ?>

                                        <script>
                                            var days = <?php echo json_encode($days); ?>;
                                            var customerCounts = <?php echo json_encode($customerCounts); ?>;
                                        </script>



                                        <div style="width: 500px; margin: 0 auto;">
                                            <canvas id="LineChart2"></canvas>
                                        </div>

                                        <script>
                                            var ctx = document.getElementById('LineChart2').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: days,
                                                    datasets: [{
                                                        label: 'Customers per Day',
                                                        data: customerCounts,
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 1,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: false,
                                                            position: 'bottom' // or 'top', 'left', 'right' based on your preference
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Customers per Day</h5>

                                    </div>

                                    <hr>



                                </div>

                            </div>

                        </div>
                    </div>  <!-- END ROW 2 - ADMIN DASHBOARD - LINE CHART -->






                    <div class="row"> <!-- ROW 3 - ADMIN DASHBOARD - PIE CHART -->

                        <div class="card-body" id="cards_body4" style="justify-content: center; background: white;"> <!--BLUE-->
                        
                            <div class="row">
                                
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-6" style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">
                                        <h5>Pie Chart</h5>
                                    </div>
                                    <div class="col-6">
                                        <h5></h5>
                                    </div>
                                    <hr>
                                </div>


                                <div class="row">

                                    <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <div style="width: 400px; margin: 0 auto;">
                                            <canvas id="pieChart1"></canvas>
                                        </div>

                                        <script>
                                            <?php
                                            // Sample SQL query to calculate average ratings
                                            $sql = "SELECT rating, COUNT(*) as count FROM tbl_feedback GROUP BY rating";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $ratings = [];
                                            $counts = [];

                                            foreach ($result as $row) {
                                                $ratings[] = $row['rating'];
                                                $counts[] = $row['count'];
                                            }
                                            ?>

                                            // Create a JavaScript array with your PHP data
                                            var ratings = <?php echo json_encode($ratings); ?>;
                                            var counts = <?php echo json_encode($counts); ?>;

                                            var ctx = document.getElementById('pieChart1').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: ratings,
                                                    datasets: [{
                                                        data: counts,
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(255, 159, 64, 0.6)',
                                                            'rgba(255, 205, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                        ],
                                                    }]
                                                },
                                                options: {
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    var label = context.label + 'rating'|| '';
                                                                    var value = context.parsed || 0;
                                                                    var total = context.dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                                                        return previousValue + currentValue;
                                                                    });
                                                                    var percentage = (value / total * 100).toFixed(2) + '%';
                                                                    return percentage + " (" + value + " of " + total + " Feedbacks)";
                                                                    
                                                                }

                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                            
                                        </script>
                                        
                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Rating Percentage</h5>

                                    </div>



                                    <!-- <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <div style="width: 400px; margin: 0 auto;">
                                            <canvas id="pieChart2"></canvas>
                                        </div>

                                        <script>
                                            <?php
                                            // Sample SQL query to calculate average ratings
                                            $sql = "SELECT rating, COUNT(*) as count FROM tbl_feedback GROUP BY rating";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $ratings = [];
                                            $counts = [];

                                            foreach ($result as $row) {
                                                $ratings[] = $row['rating'];
                                                $counts[] = $row['count'];
                                            }
                                            ?>

                                            // Create a JavaScript array with your PHP data
                                            var ratings = <?php echo json_encode($ratings); ?>;
                                            var counts = <?php echo json_encode($counts); ?>;

                                            var ctx = document.getElementById('pieChart2').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: ratings,
                                                    datasets: [{
                                                        data: counts,
                                                        backgroundColor: [
                                                            'rgba(255, 199, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                            'rgba(255, 205, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(153, 102, 255, 0.6)',
                                                        ],
                                                    }]
                                                },

                                                options: {
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    var label = context.label + 'rating'|| '';
                                                                    var value = context.parsed || 0;
                                                                    var total = context.dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                                                        return previousValue + currentValue;
                                                                    });
                                                                    var percentage = (value / total * 100).toFixed(2) + '%';
                                                                    return percentage + " (" + value + " of " + total + " Feedbacks)";
                                                                    
                                                                }

                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                            
                                        </script>

                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Products Percentage</h5>

                                    </div> -->

                                    <hr>



                                </div>

                            </div>

                        </div>
                    </div>  <!-- END ROW 3 - ADMIN DASHBOARD - PIE CHART -->











                    













                    <!-- </div> BODY END -->
                </div>
            </div>

        </div>
    </div>
    <!-- END ADMIN DASHBOARD -- FOR VIEWING ADMIN DASHBOARD -->












    <!-- START BODY1 -->
    <div class="body1">
        <div class="container">
            <div class="bg-transparent text-center d-flex align-items-center justify-content-center" style="height: 100vh;">
                
                <div>
                    <h3 style="position: absolute; width: 200px; color: white; margin-left: 0px; margin-top: -300px;"
                    >Customer List</h3>
                </div>
                    
                    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                    style="width: 150px; float: right; margin-top: -50px; margin-right: -660px;" onclick="editUser()"
                    >Edit User</button> -->

                    <div class="col-12" style="margin-top: 0px;">
                        <!-- Step 4: Display data in the table format -->
                        <div class="scrollable-content" id="inputfields" style="margin-top: -95px; height: 400px; overflow-y: auto;">
                            <?php
                                // Step 2: Fetch all data from tbl_customer_info with column aliases
                                $sql = "SELECT customer_ID AS 'Customer ID',
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
                                FROM tbl_customer_info";

                                // $sql = "SELECT customer_ID AS 'Customer ID',
                                //     CONCAT(firstName, ' ', lastName) AS 'Full Name',
                                //     email AS 'Email',
                                //     dateAdded AS 'Creation Date'
                                // FROM tbl_customer_info";

                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Step 3: Create arrays to store the data
                                $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="scrollable-content" id="inputfields" style="position: absolute; height: 470px; overflow-y: auto; width: 1300px;">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Move the button outside of the table -->
                                        <table class="table table-bordered" style="color: white;">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0];

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: rgb(255, 204, 0); color: black;'>$alias</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the data and populate the table
                                                foreach ($customerData as $row) {
                                                    echo "<tr onclick='highlightRow(this)' style='cursor: pointer;'>";
                                                    
                                                    // Display the data columns
                                                    foreach ($row as $key => $value) {
                                                        echo "<td>$value</td>";
                                                    }
                                                    
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .highlighted-row {
                                    background-color: rgba(248, 215, 218, 0.2) !important;
                                }
                                /* Remove the edit-column class and style */
                            </style>

                            <script>
                                function highlightRow(row) {
                                    // Remove 'highlighted-row' class from all rows
                                    var rows = document.querySelectorAll('tr');
                                    rows.forEach(function (r) {
                                        r.classList.remove('highlighted-row');
                                    });

                                    // Add 'highlighted-row' class to the clicked row
                                    row.classList.add('highlighted-row');
                                }

                                // Function to handle the "Edit" button click
                                function editUser() {
                                    // Find the highlighted row
                                    var highlightedRow = document.querySelector('.highlighted-row');

                                    // Check if a row is highlighted
                                    if (highlightedRow) {
                                        // Get the customer_ID from the highlighted row
                                        var customerID = highlightedRow.cells[0].textContent; // Assuming customer_ID is in the first column
                                        var firstName = highlightedRow.cells[1].textContent;
                                        var middleName = highlightedRow.cells[2].textContent;
                                        var lastName = highlightedRow.cells[3].textContent;
                                        var street = highlightedRow.cells[4].textContent;
                                        var barangay = highlightedRow.cells[5].textContent;
                                        var municipality = highlightedRow.cells[6].textContent;
                                        var province = highlightedRow.cells[7].textContent;
                                        var zipcode = highlightedRow.cells[8].textContent;
                                        var phoneNumber = highlightedRow.cells[9].textContent;
                                        var birthDate = highlightedRow.cells[10].textContent;
                                        // var gender = highlightedRow.cells[11].textContent;

                                        // Set the customer_ID value in the offcanvas input field
                                        document.getElementById('customer_ID').value = customerID;
                                        document.getElementById('firstname').value = firstName;
                                        document.getElementById('middlename').value = middleName;
                                        document.getElementById('lastname').value = lastName;
                                        document.getElementById('street').value = street;
                                        document.getElementById('barangay').value = barangay;
                                        document.getElementById('municipality').value = municipality;
                                        document.getElementById('province').value = province;
                                        document.getElementById('zipcode').value = zipcode;
                                        document.getElementById('phonenumber').value = phoneNumber;
                                        document.getElementById('birthdate').value = birthDate;
                                        // document.getElementById('').value = gender;

                                        // Open the offcanvas
                                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
                                        offcanvas.show();
                                    } else {
                                        alert("Please select a row before clicking 'Edit User'.");
                                    }
                                }
                            </script>

                        </div>

                    </div>
            </div>
        </div>
    </div>
    <script>
                    // Function to generate options for day select
                    function generateDayOptions() {
                        var daySelect = document.getElementById("day");
                        daySelect.innerHTML = "";
                    
                        for (var i = 1; i <= 31; i++) {
                        var option = document.createElement("option");
                        option.text = i;
                        option.value = i;
                        daySelect.appendChild(option);
                        }
                    }
                    
                    // Function to generate options for month select
                    function generateMonthOptions() {
                        var monthSelect = document.getElementById("month");
                        monthSelect.innerHTML = "";
                    
                        var months = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                        ];
                    
                        for (var i = 0; i < months.length; i++) {
                        var option = document.createElement("option");
                        option.text = months[i];
                        option.value = i + 1;
                        monthSelect.appendChild(option);
                        }
                    }
                    
                    // Function to generate options for year select
                    function generateYearOptions() {
                        var yearSelect = document.getElementById("year");
                        yearSelect.innerHTML = "";
                    
                        var currentYear = new Date().getFullYear();
                    
                        for (var i = currentYear; i >= 1800; i--) {
                        var option = document.createElement("option");
                        option.text = i;
                        option.value = i;
                        yearSelect.appendChild(option);
                        }
                    }
                    
                    // Call the functions to generate options
                    generateDayOptions();
                    generateMonthOptions();
                    generateYearOptions();
                </script>
    <!-- END BODY1 -->


















     <!-- START BODY2 -->
     <div class="body2">
        <div class="container">
            <div class="bg-transparent text-center d-flex align-items-center justify-content-center" style="height: 100vh;">
                
                <div>
                    <h3 style="position: absolute; width: 200px; color: white; margin-left: 0px; margin-top: -315px;"
                    >Feedback List</h3>
                </div>
                    
                    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                    style="width: 150px; float: right; margin-top: -50px; margin-right: -660px;" onclick="editUser()"
                    >Edit User</button> -->

                    <div class="col-12" style="margin-top: 0px;">
                        <!-- Step 4: Display data in the table format -->
                        <div class="scrollable-content" id="inputfields" style="margin-top: -110px; height: 400px; overflow-y: auto;">
                                <?php
                                // Step 2: Fetch all data from tbl_customer_info
                                $sql = "SELECT * FROM tbl_customer_info";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Step 3: Create arrays to store the data
                                $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Step 2: Fetch data from tbl_customer_info
                                $sql = "SELECT
                                    ci.customer_ID AS 'Customer ID',
                                    CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Full Name',
                                    fb.opinion AS 'Opinion',
                                    fb.suggestion AS 'Suggestion',
                                    fb.question AS 'Question',
                                    fb.rating AS 'Rating',
                                    fb.date AS 'Date'
                                FROM tbl_customer_info AS ci
                                JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID";

                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Step 3: Create arrays to store the data
                                $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <!-- Step 4: Display data in the table format with renamed columns -->
                                <div class="scrollable-content" id="inputfields" style="position: absolute; height: 470px; overflow-y: auto; width: 1300px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-bordered" style="color: white;">
                                                <thead>
                                                    <tr>
                                                        <?php
                                                        // Display column aliases as headers
                                                        $aliasRow = $customerData[0];

                                                        foreach ($aliasRow as $alias => $value) {
                                                            echo "<th style='background-color: rgb(255, 204, 0); color: black;'>$alias</th>";
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Loop through the data and populate the table
                                                    foreach ($customerData as $row) {
                                                        echo "<tr>";
                                                        foreach ($row as $value) {
                                                            echo "<td>$value</td>";
                                                        }
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
            </div>
        </div>
    </div>
    <!-- END BODY2 -->









    


    



    

</body>
</html>



<script>
    function to_adminacc() {
        window.location.href = 'admin_account.php';
    }
</script>








































