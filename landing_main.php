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

        <title>Nasara</title>
    </head>
    <body>
        <script src="assets/js/jquery-3.7.1.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/global.js"></script>

        
        <link rel="stylesheet" href="pages/landing/style_land.css">


        <!--PARRALAX-->

        <div class="container-fluid">
            <div class="parallax text-center">
                <div class="row">
                    <img src="icons/NASARA_LOGO_COLORED_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">


                    <div class="col-1">
                        
                    </div>
                    <div class="col-4 pt-1">
                        <!-- <img src="pages/home/LOGO1.png" class="img-fluid"> -->
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5 text-center">


                    <img src="icons/CUSTOMER_YELLOW.png" class="img-fluid" id="customer_yellow" alt="">
                    <img src="icons/BACKGROUND_FEEDBACK_WHITE_SHADOWED_PNG.png" class="img-fluid" id="feedback_white" alt="">

                        
                    
                        <button class="btn" type="button" id="sign_in" onclick="window.location.href='login_main.php'">
                            SIGN IN
                        </button>
                                
                        <button class="btn" type="button" id="sign_up" data-bs-toggle="modal" data-bs-target="#modal_registration">
                            SIGN UP
                        </button>

                        
                    </div>
                </div>
            </div>
        </div>

        <!--END PARRALAX-->

        <!-- CUSTOMER REGISTRATION MODAL -->
        <div class="modal fade" id="modal_registration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <img src="icons/GIF_REGISTER.gif" style="width: 1.6in; height: .9in; margin-right: -10px;" id="register_gif"> -->
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: lightgray;">Customer Registration</h5>
                    </div>
                    <div class="modal-body">

                        <form id="registration_form" method="POST" action="actions/insert_new_account.php">
                            <div class="input" id="inputfields">
                                <input type="text" placeholder="Firstname" class="firstname" name="firstname" id="row1" required/>
                                <input type="text" placeholder="Lastname" class="lastname" name="lastname" id="row1" required/>
                                <input type="text" placeholder="Email" class="email" name="email" id="row2" required/> 
                                <input type="text" placeholder="Password" class="password" name="password" id="row3" required/> 
                                <input type="text" placeholder="Confirm Password" class="confirmpassword" name="confirmpassword" id="row4" required/> 
                                <!-- <p id="message" style="background: white;"></p> -->
                            </div>
                            <!-- <hr style="color: white; border: solid 1px white;"> -->
                            <div class="boxandlink">
                                <input type="checkbox" id="privacy-checkbox" name="privacy-checkbox" required>
                                <label for="privacy-checkbox" id="privacy-link" style="color: #f5f5f5;">I already read and understand the <a href="privacy_details_main.php"
                                style="color: white;"><b>privacy details</b></a>.</label>
                            </div>
                            <!-- <button type="submit" class="submit" name="submit" id="modalsubmit">Create account</button> ORIGINAL-->
                            
                            <!-- <button type="button" onclick="checkPassword()">SUBMIT</button> NEW-->
                            
                            <button type="submit" class="btn" name="submit" id="modalsubmit" onclick="checkPassword(event)">Create</button>
                            <button type="button" class="btn btn-secondary" id="closeModalBtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button id="closeModalBtn" data-bs-dismiss="modal">Back</button> -->
                            
                        </form>
                        
                            
                
                    </div>
                
                </div>
            </div>
        </div>

        <!-- END CUSTOMER REGISTRATION MODAL -->
            

            
        

    
    <script>
        
        function checkPassword(event) {

            let password = document.getElementById("row3").value;
            let cnfrmPassword = document.getElementById("row4").value;
            console.log(password, cnfrmPassword);
            let message = document.getElementById("message");

            if (password.length !== 0) {
                if (password === cnfrmPassword) {
                    // message.textContent = "Passwords match";
                    // alert("Passwords match");

                    // If passwords match, you can manually submit the form here:
                     document.getElementById("registration_form").submit();

                     
                } else {
                    event.preventDefault(); // Prevent the form from submitting
                    // message.textContent = "Passwords don't match";
                    alert("Passwords don't match");
                }
            } else {
                event.preventDefault(); // Prevent the form from submitting
                alert("Password can't be empty!");
                message.textContent = "";
            }
        }

    </script>

        
        



        <!-- <div class="row bg-transparent"> REASON WHY HORIZONTAL SCROLLBAR BELOW APPEARS-->
        <div class="boodie">
        

            <img src="icons/BUBBLE.png" class="img-fluid" id="bubble" alt="">
            
            <div class="mid text-center d-flex align-items-center justify-content-center">

                <img src="images_admin/<?php echo $adminimage; ?>" class="img-fluid zoomable-image rounded-square"
                style="width: 230px; height: 230px; border: solid 10px lightblue; border-radius: 50%; margin-top: -1180px; margin-left: -400px;">

                <h1 style="position: absolute; font-size: 50px; color: white; width: 777px; margin-top: -420px; z-index: 999;">Your Voice, Our Excellence!</h1>
                <!-- <h1 style="position: absolute; color: white; width: 500px; margin-top: 350px; z-index: 999;">Our Excellence!</h1> -->
                <img src="icons/2PERSONS_GIF.gif" class="img-fluid" style="position: absolute; width: 500px; margin-top: 50px;" alt="">
                <img src="icons/3PERSONS_PNG.png" class="img-fluid" style="position: absolute; width: 400px; margin-top: -150px; margin-left: 1000px; filter: drop-shadow(10px 10px 20px rgba(0, 0, 0, 0.5));" alt="">

                <img src="icons/WEWANTYOURFEEDBACK_PNG.png" class="img-fluid" style="position: absolute; width: 400px; margin-top: -150px; margin-left: -1000px; filter: drop-shadow(10px 10px 20px rgba(0, 0, 0, 0.5));" alt="">


            </div>

        </div>
    
        


    </body>


    <footer class="bg-transparent text-light text-center bg-dark p-3" style="height: 10px; margin-top: -55px;">
            <p>&copy; 2024 NasaraStore. All rights reserved.</p>
        </footer>

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




