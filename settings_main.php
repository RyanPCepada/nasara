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
            phoneNumber FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();

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
 
    <title>DevBugs</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/account/style_acc.css">

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="" style="width: 7%">
            <img src="pages/home/LOGO.png" class="img-fluid" alt="">
        </div>
        <div class="container-fluid">
            <a class="navbar-brand" id="logoname">DevBugs/OctaWiz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="m-2">
                    <a onclick="to_home()" href="home_main.php" style="text-decoration: underline;" id="homeLink">Home</a>
                    <a onclick="to_aboutUs()" aria-current="page" id="aboutUsLink">About Us</a>
                    <a onclick="to_contactUs()" id="contactUsLink">Contact Us</a>
                    <form style="margin-left: 200px;">
                        <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" id="search">
                    </form>
                </div>
            </div>

            <button id="notif" type="button" class="btn btn-secondary position-relative" style="margin-right: 25px;">
                Notifications
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    99+
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>
            
            <img src="pages/home/account_icon.png" class="img-fluid" alt="">
            <div class="m-2 text-light">
                <b class="bg-transparent" id="accountLink" onclick="to_account()" style="cursor: pointer;"> <img src="navigation/user.png" alt="">Account</b>
            </div>
        </div>
    </nav>
    

    <div class="accbg">
        <div class="container">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 bg-transparent">
                    <div class="col-2 ">
                        <!-- <button class="text-primary" style="width: 200px;">Profile</button> -->
                        <button type="button" class="btn btn-primary" id="openProfileModalBtn" data-bs-toggle="modal" data-bs-target="#modal_profile"
                            style="width: 200px; margin-top: 20px">
                            Profile
                        </button>
                    </div>
                    <div class="col-2 ">
                        <p> </p>
                    </div>
                    <div class="col-2 ">
                        <!-- <button onclick="to_back()" style="width: 200px;">Background Information</button> -->
                        <button type="button" class="btn btn-primary" id="openBGInfoModalBtn" data-bs-toggle="modal" data-bs-target="#modal_BGInfo" style="width: 200px;">
                            Background Information
                        </button>
                    </div>
                    <div class="col-2 ">
                        <p> </p>
                    </div>
                    <div class="col-2 ">
                        <button style="width: 200px;">Settings</button>
                    </div>
                    <div class="col-2 ">
                        <p> </p>
                    </div>
                    <div class="col-2 text-danger">
                        <!-- <button class="text-danger" style="width: 200px;"><a id="logout" href="http://localhost/DevBugs/login_main.php">Log Out</a></button> -->
                        <form action="actions/logoutAction.php" method="post">
                            <button class="text-danger" style="width: 200px;" type="submit" id="logout" href="http://localhost/DevBugs/login_main.php">Log Out</button>
                        </form>

                    </div>
                    <div class="col-2 ">
                        <p> </p>
                    </div>
                </div>
                <div class="col-8 bg-transparent">
                    <div class="row">
                        <div class="col-4">
                            <div class="m-2" style="width: 80%">
                                <img src="pages/account/profpic.png" class="img-fluid" alt="">
                            </div>
                        </div>



                        <div class="col-8">
                            <h1 class="text-light" style="width: 700px; margin-left: -30px; margin-top: 70px;">
                                <?php echo $firstName . ' ' . $middleName. ' ' . $lastName; ?>
                                <!-- <h1>Welcome, <php echo $firstName . ' ' . $lastName; ?></h1> -->
                            </h1>
                            <p class="text-light" name="bio" style="width: 300px; margin-left: -30px;">"Trust the Process, Everything takes Time."</p>
                        </div>

                        


                    </div>
                    <div class="row" style="margin-left: 20px;">
                        <div class="col text-light">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- PROFILE MODAL 1 -- FOR EDITING PROFILE -->
    <div class="modal fade" id="modal_profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Profile</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">

                    <form id="registration_form" method="POST" action="actions/edit_profile.php">
                        <div class="input" id="inputfields" style="height: 330px;">
                            <p class="sub_title_2" id="sub_title_name">Name</p>
                            <input type="text" placeholder="Firstname" class="firstname" name="firstname" id="p_row1" value="<?php echo $firstName; ?>"/>
                            <input type="text" placeholder="Middlename" class="middlename" name="middlename" id="p_row1" value="<?php echo $middleName; ?>" />
                            <input type="text" placeholder="Lastname" class="lastname" name="lastname" id="p_row1" value="<?php echo $lastName; ?>" />

                            <p class="sub_title_2" id="sub_title_address">Address</p>
                            <input type="text" placeholder="Street" class="street" name="street" id="p_row2" value="<?php echo $street; ?>"/>
                            <input type="text" placeholder="Barangay" class="barangay" name="barangay" id="p_row2" value="<?php echo $barangay; ?>" />

                            <input type="text" placeholder="Municipality" class="municipality" name="municipality" id="p_row3" value="<?php echo $municipality; ?>" />
                            <input type="text" placeholder="Province" class="province" name="province" id="p_row3" value="<?php echo $province; ?>"/>

                            <input type="text" placeholder="Zipcode" class="zipcode" name="zipcode" id="p_row4" value="<?php echo $zipcode; ?>" />
                            <input type="text" placeholder="Phone number" class="phonenumber" name="phonenumber" id="p_row4" value="<?php echo $phoneNumber; ?>" />

                            <!-- <input type="date" placeholder="Birthdate" class="birthdate" name="birthdate" id="p_row5" value="<php echo $birthDate; ?>" /> -->

                            <label id="sub_title_dob">Date of Birth</label>
                            <label id="sub_title_gend">Gender</label>
                            <div class="options">
                                <!-- Update these lines in the profile modal -->
                                <select class="box1" id="day" name="day">
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo '<option value="' . $i . '" ' . ($day == $i ? 'selected' : '') . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select class="box2" id="month" name="month">
                                    <?php
                                    foreach ($months as $key => $value) {
                                        echo '<option value="' . $key . '" ' . ($month == $key ? 'selected' : '') . '>' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                                <select class="box3" id="year" name="year">
                                    <?php
                                    $currentYear = date('Y');
                                    for ($i = $currentYear; $i >= $currentYear - 100; $i--) {
                                        echo '<option value="' . $i . '" ' . ($year == $i ? 'selected' : '') . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>

                                <input type="radio" id="fem" name="gender" value="Female" <?php echo ($gender === 'Female') ? 'checked' : ''; ?> required>
                                <label for="fem">Female</label>
                                <input type="radio" id="mal" name="gender" value="Male" <?php echo ($gender === 'Male') ? 'checked' : ''; ?> required>
                                <label for="mal">Male</label>
                            </div>


                            <!-- <input type="text" placeholder="Gender" class="gender" name="gender" id="p_row5" value="<?php echo $gender; ?>" /> -->

                            <!-- <p id="message" style="background: white;"></p> -->
                        </div>
                        <!-- <button type="submit" class="submit" name="submit" id="modalsubmit">Create account</button> ORIGINAL-->
                        
                        <!-- <button type="button" onclick="checkPassword()">SUBMIT</button> NEW-->
                        
                            <button type="submit" class="submit" name="submit" id="prof_modalsave">Save</button>
                            <button type="button" class="btn btn-secondary" id="prof_closeModalBtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button id="closeModalBtn" data-bs-dismiss="modal">Back</button> -->
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>

    <!-- PROFILE MODAL 2 -- FOR EDITING BACKGROUND INFORMATION -->
    <div class="modal fade" id="modal_BGInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Background Information</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">

                    <form id="registration_form" method="POST"> <!-- action="actions/edit_profile.php"-->
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
                            <!-- <p id="message" style="background: white;"></p> -->
                                
                        </div>

                            <!-- <button type="submit" class="submit" name="submit" id="modalsubmit">Create account</button> ORIGINAL-->
                            <!-- <button type="button" onclick="checkPassword()">SUBMIT</button> NEW-->
                            
                            <button type="submit" class="submit" name="submit" id="bg_modalsave">Save</button>
                            <button type="button" class="btn btn-secondary" id="bg_closeModalBtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button id="closeModalBtn" data-bs-dismiss="modal">Back</button> -->
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>


    
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

                gend: $('.gender').val()


                

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
        // Function to underline a link and remove underline from others
        function underlineLink(linkId) {
            const links = ["homeLink", "aboutUsLink", "contactUsLink", "accountLink"];
            for (const id of links) {
                const link = document.getElementById(id);
                if (id === linkId) {
                    link.style.textDecoration = "underline";
                } else {
                    link.style.textDecoration = "none";
                }
            }
        }
        underlineLink("accountLink");

        document.getElementById("homeLink").addEventListener("click", function() {
            underlineLink("homeLink");
        });
        document.getElementById("aboutUsLink").addEventListener("click", function() {
            underlineLink("aboutUsLink");
        });
        document.getElementById("contactUsLink").addEventListener("click", function() {
            underlineLink("contactUsLink");
        });
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

</body>
</html>

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

