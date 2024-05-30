<?php
session_start();  // Start the session to access session variables

// Check if the user is logged in (you can adjust this based on your session variable)
if (isset($_SESSION['customerID'])) {
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
        $customerID = $_SESSION['customerID'];
        $query = $conn->prepare("SELECT firstName, middleName, lastName, street, barangay, municipality, province, zipcode, birthdate, gender,
            phoneNumber, password, image FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();


        //FETCH ACTIVITY LOGS FOR HISTORY LIST
        // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        $sql1 = "SELECT activity FROM tbl_activity_logs WHERE customer_ID = $customerID";
        $sql2 = "SELECT dateAdded FROM tbl_activity_logs WHERE customer_ID = $customerID";
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

        $firstName = $user['firstName'];
        $middleName = $user['middleName'];
        $lastName = $user['lastName'];
        $street = $user['street'];
        $barangay = $user['barangay'];
        $municipality = $user['municipality'];
        $province = $user['province'];
        $zipcode = $user['zipcode'];
        
        // Extract day, month, and year from the birthdate
        $birthDate = new DateTime($user['birthdate']);
        $birthDay = $birthDate->format('d');
        $birthMonth = $birthDate->format('m');
        $birthYear = $birthDate->format('Y');

        $gender = $user['gender'];
        $phoneNumber = $user['phoneNumber'];
        $password = $user['password'];

        // $customerID = $_SESSION['customer_ID'];
        // $firstName = $user['firstName'];
        $image = $user['image'];


        // Fetch all feedback records for the customer
        $query = $conn->prepare("SELECT feedback_ID, products, services, convenience, rating, date FROM tbl_feedback WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();
        $feedbackRecords = $query->fetchAll(PDO::FETCH_ASSOC);
        

        // Fetch all audio feedback files for the customer
        $query = $conn->prepare("SELECT audio FROM tbl_audio_feedback WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();
        $audioFiles = $query->fetchAll(PDO::FETCH_ASSOC);


        $customerID = $_SESSION['customerID'];
        
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

    <title>Nasara - Account</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/account/style_acc.css">

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">

        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">
        <h1 style="margin-left: 360px; font-family: Cooper; color: white;">Dual Feedback System</h1>

        <button class="btn btn-secondary" type="button" id="icon_home" onclick="to_home()" href="home_main.php">
            <i class="fas fa-home"></i>
        </button>

        <img src="images/<?php echo $image; ?>" id="icon_account" class="img-fluid zoomable-image rounded-square"
        onclick="to_account()">

        <!--https://t3.ftcdn.net/jpg/05/65/04/24/360_F_565042407_Qy6b2KlIVKjukKsWYuZcWghZRaxp5R3K.webp-->

    </nav>

    

    <div class="acc_bg_odd">
        <div class="container text-center d-flex align-items-center justify-content-center"> <!-- style="background-color: yellow;"-->

            <!-- 1ST ROW -->
            <div class="row col-12">

                <div class="col-3">

                </div>

                <div class="col-6 bg-transparent">
                    <!-- FOR PROFILE PICTURE -->
                    <div class="row text-center d-flex align-items-center justify-content-center"> 
                        <div class="m-2" style="width: 110%; position: relative; padding-top: 10px;">
                            <?php
                                $sql = "SELECT image FROM tbl_customer_info WHERE customer_ID = :customerID";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
                                $stmt->execute();

                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $image = $result['image'];
                            ?>
                            <img src="images/<?php echo $image; ?>" class="img-fluid zoomable-image rounded-square" style="width: 2in; height: 2in;">
                            <i class="fa fa-camera" onclick="openChangeProfilePicModal()" style="position: absolute; margin-right: 218px;"></i>
                        </div>
                    </div> 
                    <!-- END FOR PROFILE PICTURE -->

                    <!-- FOR NAME -->
                    <div class="row text-center d-flex align-items-center justify-content-center"> 
                        <h1 class="text-light" style="position: relative; width: 700px; padding: 20px;">
                            <?php echo $firstName . ' ' . $middleName. ' ' . $lastName; ?>
                        </h1>
                    </div> 
                    <!-- END FOR NAME -->
                    <hr style="color: white;">



                    <div class="row col-12"> <!--FOR BUTTONS-->
                            <div class="col-2">
                                <button class="btn btn-primary" type="button" id="icon_editprofile" data-bs-toggle="modal" data-bs-target="#modal_profile">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-secondary" type="button" id="icon_password" data-bs-toggle="modal" data-bs-target="#modal_changeyourpassword">
                                    <i class="fas fa-key"></i>
                                </button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-danger" type="button" id="icon_history" data-bs-toggle="modal" data-bs-target="#modal_history">
                                    <i class="fas fa-history"></i>
                                </button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-warning" type="button" id="icon_privacy" data-bs-toggle="modal" data-bs-target="#modal_termsandprivacypolicy">
                                    <i class="fas fa-file-alt"></i>
                                    <!-- <i class="fas fa-file-contract"></i> -->
                                </button>
                            </div>
                            <div class="col-2">
                                <!-- <button class="btn btn-success" type="button" id="icon_blank" data-bs-toggle="modal" data-bs-target="#modal_profile">
                                    <i class=""></i>
                                </button> -->
                            </div>
                            <div class="col-2">
                                <form action="actions/logoutAction.php" method="post">
                                    <button class="btn btn-dark" type="submit" id="icon_logout" onclick="window.location.href='login_main.php'">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>




                            <!-- <div class="col-2">
                                <button type="button" class="btn btn-primary" id="openSettingsModalBtn" data-bs-toggle="modal" data-bs-target="#modal_settings"
                                    style="position: relative; width: 200px; height: 60px;"
                                    >Settings
                                </button>
                            </div>
                            <div class="col-2 text-danger">
                                <form action="actions/logoutAction.php" method="post">
                                    <button class="btn btn-dark" type="submit" id="logout" onclick="window.location.href='login_main.php'"
                                        style="position: relative; width: 200px; height: 60px;"
                                        >Log Out
                                    </button>
                                </form>
                            </div> -->
                        
                    </div><!-- END FOR BUTTONS -->
                    
                </div>


                <div class="col-3">

                </div>

            </div>
            <!-- END 1ST ROW -->



        </div>
    </div>

    

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

                    <form id="editprofile_form" method="POST" action="actions/edit_profile.php">
                        <div class="input" id="inputfields" style="height: 400px;">
                            <p class="sub_title_2" id="sub_title_name">Name</p>
                            <input type="text" placeholder="Firstname" class="firstname" name="firstname" id="p_row1" value="<?php echo $firstName; ?>"/>
                            <input type="text" placeholder="Middlename" class="middlename" name="middlename" id="p_row1" value="<?php echo $middleName; ?>" />
                            <input type="text" placeholder="Lastname" class="lastname" name="lastname" id="p_row1" value="<?php echo $lastName; ?>" />
                            <hr>
                            <p class="sub_title_2" id="sub_title_address">Address</p>
                            <input type="text" placeholder="Street" class="street" name="street" id="p_row2" value="<?php echo $street; ?>"/>
                            <input type="text" placeholder="Barangay" class="barangay" name="barangay" id="p_row2" value="<?php echo $barangay; ?>" />
                            
                            <input type="text" placeholder="Municipality" class="municipality" name="municipality" id="p_row3" value="<?php echo $municipality; ?>" />
                            <input type="text" placeholder="Province" class="province" name="province" id="p_row3" value="<?php echo $province; ?>"/>
                            
                            <input type="text" placeholder="Zipcode" class="zipcode" name="zipcode" id="p_row4" value="<?php echo $zipcode; ?>" />
                            <input type="text" placeholder="Phone number" class="phonenumber" name="phonenumber" id="p_row4" value="<?php echo $phoneNumber; ?>" />

                            <!-- <input type="date" placeholder="Birthdate" class="birthdate" name="birthdate" id="p_row5" value="<php echo $birthDate; ?>" /> -->
                            <hr>
                            <label id="sub_title_dob">Date of Birth</label>
                            <label id="sub_title_gend">Gender</label>
                            <div class="options">
                                
                                <select class="box1" id="day" name="day">
                                    <option value="<?php echo $birthDay; ?>" selected><?php echo $birthDay; ?></option>
                                </select>

                                <select class="box2" id="month" name="month">
                                    <option value="<?php echo $birthMonth; ?>" selected><?php echo $birthMonth; ?></option>
                                </select>

                                <select class="box3" id="year" name="year">
                                    <option value="<?php echo $birthYear; ?>" selected><?php echo $birthYear; ?></option>
                                </select>

                                <input type="radio" id="fem" name="gender" value="Female" <?php echo ($gender === 'Female') ? 'checked' : ''; ?> required>
                                <label for="fem">Female</label>
                                <input type="radio" id="mal" name="gender" value="Male" <?php echo ($gender === 'Male') ? 'checked' : ''; ?> required>
                                <label for="mal">Male</label>
                            </div>
                            <hr>

                        </div>
                        
                        <button type="submit" class="submit" name="submit" id="prof_modalsave">Save</button>
                        <button type="button" class="btn btn-secondary" id="prof_closeModalBtn" data-bs-dismiss="modal">Close</button>
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>
    <!-- END PROFILE MODAL -- FOR EDITING PROFILE -->

    
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
    




    <!-- PROFILE PICTURE MODAL -- FOR CHANGING PROFILE PICTURE -->
    <div class="modal fade" id="changeProfilePicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Profile Picture</h5>
                </div>
                <div class="modal-body">
                    <form class="form" id="form" action="actions/update_profile_pic.php" enctype="multipart/form-data" method="post">
                        <div class="upload">
                            <?php
                                $sql = "SELECT image FROM tbl_customer_info WHERE customer_ID = :customerID";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
                                $stmt->execute();

                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $image = $result['image'];
                            ?>
                            <img src="images/<?php echo $image; ?>" id="selectedImage" style="width: 2in; height: 2in; margin-bottom: 20px;">
                            <div class="round">
                                <input type="hidden" name="id" value="<?php echo $customerID; ?>">
                                <input type="hidden" name="name" value="<?php echo $firstName; ?>">
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
                            </button> -->
                            <br>
                            <button type="button" class="btn btn-secondary" id="openTermsAndPrivacyPolicyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_termsandprivacypolicy"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Terms and Privacy Policy
                            </button>

                        </div>
                            <!-- <button type="submit" class="submit" name="submit" id="sett_modalsave">Save</button> -->
                            <button type="button" class="btn btn-secondary" id="sett_closeModalBtn" data-bs-dismiss="modal"
                            
                            window.location.href = 'account_main.php';>Close</button> <!--WORK HERE!!!!!-->
                        
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
                    <form id="change_password_form" method="POST" action="actions/change_password.php">
                        <div class="input" id="inputfields" style="height: 350px;">

                            <div class="row">
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Enter old password</h>
                                <input type="password" class="oldpassword" name="oldpassword" id="cyp_row1" style="margin-top: 10px;" required/>
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Enter new password</h>
                                <input type="password" class="newpassword" name="newpassword" id="cyp_row2" style="margin-top: 10px;" required/>
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Confirm new password</h>
                                <input type="password" class="confirmnewpassword" name="confirmnewpassword" id="cyp_row3" style="margin-top: 10px;" required/>
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
                $password = $user['password'];
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

                                for ($i = $count - 1; $i >= 0; $i--) {
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
                        <b>Nasara Store Customer Feedback Management System</b>
                            <br><br>
                            Effective Date: September 09, 2010
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
                            If you have any questions or concerns about these terms and policies, please contact us at NasaraStore2010@gmail.com.
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
        function insertNewUser(){
            $.post("actions/insert_new_account.php", {
                fname: $('.firstname').val(),
                mname: $('.middlename').val(),
                lname: $('.lastname').val(),
                st: $('.street').val(),
                brgy: $('.barangay').val(),
                mun: $('.municipality').val(),
                prov: $('.province').val(),
                zipc: $('.zipcode').val(),
                pnum: $('.phonenumber').val(),

                day: $('.day').val(),
                month: $('.month').val(),
                year: $('.year').val(),
                bdate: $('.year') + '-' + $('.month') + '-' + $('.day').val(),

                gend: $('.gender').val(),

                
                pword: $('.password').val(),
                conpw: $('.confirmpassword').val(),

                image: $('.image').val()
                

    // Combine the values into a single date string in YYYY-MM-DD format
    // $bdate = "$year-$month-$day";
                
            }, function (data) {
                if (data === "Registered Successfully!") { /*HERE*/
                    alert(data);
                } else {
                    alert("Insertion failed: " + data);
                }
            });
        }
    </script>


    

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







    <!-- 2ND ROW -->
    <div class="acc_bg_even bg-primary">
        <div class="col-12 container d-flex align-items-center justify-content-center" style="width: 100%; padding: 40px;">

            <div class="row col-6">
                <div class="row" style="width: 100%; padding: 40px; background: #ddf7de; border-radius: 20px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166)">
                    <!-- <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">All feedbacks</h5> -->
                    <h1 style="position: relative; margin-top: 0px; margin-bottom: 10px; margin-left: 0px; color: gray;"
                    >Written Feedbacks</h1>
                    <!-- <h5 class="text-muted" style="margin-top: 0px; margin-left: 0px; margin-bottom: 5px;">Your Written Feedbacks</h5> -->
                    <hr>
                    <!-- <img src="icons/GIF_NEWFB.gif" style="width: 1.5in; height: .9in; margin-left: 445px; margin-top: 0px;" id="adminnotif_gif"> -->
                    
                    <!-- MY FEEDBACKS TABLE -->
                    <div class="scrollable-content" id="inputfields" style="width: 100%; height: 1200px; overflow-y: auto; color: black; background: #ecffed;">
                        <div class="" style="position: relative;">
                            <?php
                            // Fetch feedbacks for the current customer
                            $sqlFeedbacks = "
                            SELECT feedback_ID, products, services, convenience, rating, date
                            FROM tbl_feedback
                            WHERE customer_id = :customerID
                            ORDER BY date DESC";


                            $stmtFeedbacks = $conn->prepare($sqlFeedbacks);
                            $stmtFeedbacks->bindParam(':customerID', $customerID, PDO::PARAM_INT);
                            $stmtFeedbacks->execute();
                            $feedbacks = $stmtFeedbacks->fetchAll();

                            $todayFeedbacks = [];
                            $yesterdayFeedbacks = [];
                            $olderFeedbacks = [];

                            $now = new DateTime();
                            $yesterday = (clone $now)->modify('-1 day');

                            foreach ($feedbacks as $feedback) {
                                $feedbackDate = new DateTime($feedback['date']);

                                if ($feedbackDate->format('Y-m-d') == $now->format('Y-m-d')) {
                                    $todayFeedbacks[] = $feedback;
                                } elseif ($feedbackDate->format('Y-m-d') == $yesterday->format('Y-m-d')) {
                                    $yesterdayFeedbacks[] = $feedback;
                                } else {
                                    $olderFeedbacks[] = $feedback;
                                }
                            }

                            // Function to display notifications
                            function displayFeedbacks($feedbacks, $heading, $marginTop, $backgroundColor)
                            {
                                echo '<h4 style="margin-top: ' . $marginTop . '; margin-left: 15px; font-size: 20px; color: gray;">' . $heading . '</h4>';

                                if (empty($feedbacks)) {
                                    echo '<p style="margin-left: 15px; font-size: 18px; color: gray;">You have no feedback submitted ' . strtolower($heading) . '.</p>';
                                    echo '<hr>';
                                } else {
                                    // Display feedbacks
                                    foreach ($feedbacks as $feedback) {
                                    echo '<div class="row" style="background-color: #ecedff; border: solid 1px lightblue; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                        padding: 20px; border-radius: 5px; font-size: 20px; width: 95%; margin-left: 15px; margin-top: 10px;">';
                                    echo '<p style="margin: 0px;"><strong>Products:</strong> ' . $feedback['products'] . '</p>';
                                    echo '<p style="margin: 0px;"><strong>Services:</strong> ' . $feedback['services'] . '</p>';
                                    echo '<p style="margin: 0px;"><strong>Convenience:</strong> ' . $feedback['convenience'] . '</p>';
                                    echo '<p style="margin: 0px;"><strong>Rating:</strong> ' . $feedback['rating'] . '</p>';
                                    echo '<div class="col-10"><p style="color: blue; font-size: 15px; margin-top: 10px; margin-bottom: 0px;">' . formatRelativeDate($feedback['date'], $heading) . '</p></div>';
                                    echo '<div class="col-1"><span onclick="editFeedback(' . $feedback['feedback_ID'] . ')" style="cursor: pointer; margin-right: 10px;">&#9998;</span></div>';
                                    echo '<div class="col-1"><span onclick="deleteFeedback(' . $feedback['feedback_ID'] . ')" style="cursor: pointer;">&#128465;</span></div>';
                                    echo '</div>';
                                }
                                    echo '<hr>';
                                }
                            }

                            // Display "Today" feedbacks with background color #ecedff
                            displayFeedbacks($todayFeedbacks, 'Today', '20px', '#f1e9e9');

                            // Display "Yesterday" notifications with background color #ecffed
                            displayFeedbacks($yesterdayFeedbacks, 'Yesterday', '20px', '#ecffed');

                            // Display "Older" notifications with background color #f1e9e9
                            displayFeedbacks($olderFeedbacks, 'Older', '20px', '#ecedff');
                            ?>
                        </div>
                    </div>
                    <!-- END MY FEEDBACKS TABLE -->
                    <hr>

                    <script>
                        function editFeedback(id) {
                            window.location.href = 'edit_feedback.php?id=' + id;
                        }

                        function deleteFeedback(id) {
                            if (confirm('Are you sure you want to delete this feedback?')) {
                                window.location.href = 'delete_feedback.php?id=' + id;
                            }
                        }
                    </script>
                    
                    <script>
                        window.onload = function() {
                            const urlParams = new URLSearchParams(window.location.search);
                            if (urlParams.has('success')) {
                                alert('Feedback updated successfully!');
                            }
                        }
                    </script>

                </div>

            </div>
            
            <div class="row col-6">

                <div class="card-body" id="cards_body2" style="justify-content: center; background: #ecedff; border-radius: 20px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166)">
                    
                    <!-- <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.5in; height: .9in; margin-left: 445px; margin-top: 0px;" id="adminnotif_gif"> -->

                    <!-- AUDIO FEEDBACKS TABLE -->
                    <div class="card-body" id="" style="position: relative; justify-content: center; background: white; margin-top: 0px;">

                        <h3 style="margin: 20px; color: gray;">Audio Feedbacks</h3>

                        <div class="scrollable-content" id="table_audio_fb">
                            <?php
                                // For demonstration, we'll hardcode it (make sure to replace this with the actual retrieval method)
                                $currentCustomerID = $_SESSION['customerID'];
                                
                                // Fetch and display customer activities from tbl_activity_logs and audio records from tbl_audio_feedback
                                $sqlAudios = "
                                    SELECT 
                                    CONCAT('images/', ci.image) AS 'Profile picture',
                                    ci.customer_ID AS 'Customer ID',
                                    CONCAT(ci.firstName, ' ', ci.middleName, ' ', ci.lastName) AS 'Full Name',
                                    af.audio AS 'Audio',
                                    af.dateAdded AS 'Date',
                                    af.audio_ID AS 'Audio ID'
                                    FROM tbl_customer_info AS ci
                                    JOIN tbl_audio_feedback AS af ON ci.customer_ID = af.customer_ID
                                    WHERE ci.customer_ID = :currentCustomerID
                                    ORDER BY af.audio_ID DESC;
                                ";

                                $stmtAudios = $conn->prepare($sqlAudios);
                                $stmtAudios->bindParam(':currentCustomerID', $currentCustomerID, PDO::PARAM_INT);
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
                                            echo '<div class="col-11">';
                                            echo '<p style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($audio['Date'], $heading) . '</p>';
                                            echo '</div>';
                                            echo '</div>'; // Close 'col' div
                                
                                            echo '<div class="col-auto">';
                                            echo '<span onclick="deleteFeedback(' . $audio['Audio ID'] . ')" style="position: absolute; cursor: pointer; margin-left: -50px; margin-top: 35px;">&#128465;</span>'; // Delete button
                                            echo '</div>';
                                
                                            echo '<div class="col-auto">';
                                            echo '<audio controls style="width: 500px; margin-right: 50px; margin-top: 12px;">';
                                            echo '<source src="http://localhost/nasara/audios/' . htmlspecialchars($audio['Audio']) . '" type="audio/' . pathinfo($audio['Audio'], PATHINFO_EXTENSION) . '">';
                                            echo 'Your browser does not support the audio element.';
                                            echo '</audio>';
                                            echo '</div>';
                                
                                            echo '</div>'; // Close 'row' div
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

            </div>







        </div>
    </div>
    <!-- END 2ND ROW -->


</body>




<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>About Us</h5>
        <ul class="list-unstyled">
          <li>Owner: Hermenia Nasara</li>
          <li>Location: Tankulan, Manolo Fortich, Bukidnon</li>
          <!-- <li>Established: 2010</li> -->
          <!-- <li>Address: Tankulan, Manolo Fortich, Bukidnon</li> -->
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <ul class="list-unstyled">
          <li>Phone: +123456789</li>
          <li>Email: NasaraStore@gmail.com</li>
          <!-- <li>Address: Tankulan, Manolo Fortich, Bukidnon</li> -->
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Follow Us</h5>
        <ul class="list-unstyled">
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12 text-center">
        <p>&copy; Nasara Store. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>




</html>









<script>
    function to_home() {
        window.location.href = 'home_main.php';
    }
</script>

<!-- <script>
    function to_aboutUs() {
        window.location.href = 'aboutus_main.php';
    }
</script>

<script>
    function to_contactUs() {
        window.location.href = 'contactus_main.php';
    }
</script> -->

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
    function to_login() {
$.post("login_main.php", {},function (data) {
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

