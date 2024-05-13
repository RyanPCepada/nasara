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
            

            
        

        
        



        <!-- <div class="row bg-transparent"> REASON WHY HORIZONTAL SCROLLBAR BELOW APPEARS-->
        <div class="boodie">
        

            <img src="icons/BUBBLE.png" class="img-fluid" id="bubble" alt="">

            <div class="mid">

            </div>

        </div>
    
        


        <footer class="bg-transparent text-light text-center bg-dark p-3" style="height: 10px; margin-top: -55px;">
            <p>&copy; 2024 NasaraStore. All rights reserved.</p>
        </footer>

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




