<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="pages/registration/style_reg.css"> -->
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class= "body">
        <div class="main">
            <!-- Button to open the registration modal -->
            <!-- <button id="openModalBtn">Create an Account</button> -->

            <!-- Modal registration form -->
            <div id="registrationModal" class="modal">
                <div class="modal-content">
                    <h1 class="first_title">Create an Account</h1>
                    <form id="registration_form" method="POST" action="actions/insert_new_account.php">
                        <div class="input">
                            <input type="text" placeholder="Username" class="username" name="username" id="row1"  />
                            <input type="text" placeholder="Email" class="email" name="email"  id="row2"  /> 
                            <input type="text" placeholder="Password" class="password" name="password"  id="row3"  /> 
                            <input type="text" placeholder="Confirmed Password" class="confirmedpassword" name="confirmedpassword"  id="row4"  /> 
                        </div>
                        <div class="sub_title_4">
                            <input type="checkbox" id="privacy-checkbox" name="privacy-checkbox" >
                            <label for="privacy-checkbox">I already read and understand the <a href="#">privacy details</a>.</label>
                        </div>
                        <button type="submit" class="submit" name="submit">Create account</button>
                    </form>
                    <p class="sub_title_5">
                        <a href="http://localhost/DevBugs/login_main.php" style="width: 100px; background-color: white; color: black; text-align: center; border: 1px solid white; padding: 2px; text-decoration: none;">Login Form</a>
                    </p>
                    <button id="closeModalBtn">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // Function to open the registration modal
        document.getElementById("openModalBtn").addEventListener("click", function() {
            var modal = document.getElementById("registrationModal");
            modal.style.display = "block";
        });

        // Function to close the registration modal
        document.getElementById("closeModalBtn").addEventListener("click", function() {
            var modal = document.getElementById("registrationModal");
            modal.style.display = "none";
        });
    </script>
</body>
</html>

