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
            phoneNumber, image FROM tbl_customer_info WHERE customer_ID = :customerID");
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

        // $customerID = $_SESSION['customer_ID'];
        // $firstName = $user['firstName'];
        $image = $user['image'];


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

    <title>Nasara - Home</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/home/style_h.css">

  

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">

        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">

            <button class="btn btn-secondary" type="button" id="icon_home" onclick="to_home()" href="home_main.php">
                <i class="fas fa-home"></i>
            </button>

            <img src="images/<?php echo $image; ?>" id="icon_account" class="img-fluid zoomable-image rounded-square"
            onclick="to_account()">

            <div class = " m-2 text-light" >   
                <b class = "bg-transparent "  id="accountLink" onclick="to_account()" style=" cursor: pointer;"> <img src="navigation/user.png" alt=""></b>
            </div>

    </nav>



    
    <div class="body1">
        <div class="container">

        
            <div class="row" style="position: absolute; margin-left: 1107px; margin-top: 20px; width: 300px; height: 581px; background: rgba(0, 0, 0, 0.3);">
            </div>
            <div class="row" style="position: absolute; margin-left: 1107px; margin-top: 130px; width: 300px; height: 367px; background: rgba(255, 255, 255, 0.2);">
            </div>

            
            
            <div class="row">
                <img src="icons/BUBBLE_FORMS_2.png" style="position: absolute; width: 75%; margin-left: -58px; margin-top: 30px;
                    filter: drop-shadow(0px 20px 50px rgba(20, 20, 20, 20));">

                <img src="icons/ICON_FEEDBACK.png" style="position: absolute; width: 10%; margin-left: 300px; margin-top: 30px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20));">
                <img src="icons/ICON_QUESTION.png" style="position: absolute; width: 7%; height: 18%; margin-left: 980px; margin-top: 45px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(5deg);">
                <img src="icons/ICON_SUGGESTION.png" style="position: absolute; width: 11%; margin-left: 650px; margin-top: 395px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(0deg);">

                <img src="icons/ICON_1STAR.png" name="rating" value="1" id="star1" onclick="setRating(1)">
                <img src="icons/ICON_2STAR.png" name="rating" value="2" id="star2" onclick="setRating(2)">
                <img src="icons/ICON_3STAR.png" name="rating" value="3" id="star3" onclick="setRating(3)">
                <img src="icons/ICON_4STAR.png" name="rating" value="4" id="star4" onclick="setRating(4)">
                <img src="icons/ICON_5STAR.png" name="rating" value="5" id="star5" onclick="setRating(5)">
                
                <img src="icons/ICON_5_WHITE_STARS.png" style="position: absolute; margin-left: 1135px; margin-top: 497px; width: 270px; opacity: 50%">

                <script>
                    function setRating(value) {
                        // Set the value of the rating input
                        document.getElementById('box4').value = value;

                        // You can also add visual feedback like highlighting the selected stars
                        for (let i = 1; i <= 5; i++) {
                            const star = document.getElementById(`star${i}`);
                            if (i <= value) {
                                // Highlight the selected stars
                                star.classList.add('selected');
                            } else {
                                // Remove highlight from unselected stars
                                star.classList.remove('selected');
                            }
                        }
                    }
                </script>

                <img src="icons/ICON_RATEUS.png" style="position: absolute; width: 16%; margin-left: 1145px; margin-top: 45px;
                    filter: drop-shadow(0px 20px 50px rgba(20, 20, 20, 20)); transform: rotate(0deg);">

                <form id="feedback_form" method="POST" action="actions/insert_feedback.php">
                    
                    <textarea name="opinion" id="box1" placeholder="Type your opinion here"></textarea>
                    <textarea name="suggestion" id="box2" placeholder="Type your suggestion here"></textarea>
                    <textarea name="question" id="box3" placeholder="Type your question here"></textarea>
                    <input name="rating" id="box4">

                    <button type="submit" class="btn btn-dark" id="submit_feeback" data-bs-toggle="modal" data-bs-target="#modal_submit_feedback"
                        style="position: absolute; margin-left: 510px; margin-top: 642px; font-size: 25px; width: 300px; height: 70px; border-radius: 20px;">
                        Submit Feedback
                    </button>

                </form>
                    

                

            </div>

        </div>
    </div>








    
   

    <!-- DASHBOARD MODAL -- FOR VIEWING DASHBOARD -->
    <div class="modal fade" id="modal_dashboard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1400px; max-height: 1000px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="staticBackdropLabel" style="color: black; margin-left: 10px;">Customer Dashboard</h1>
                    <h3 style="margin-right: 10px;"><?php echo $firstName; ?></h1>
                </div>
                <div class="modal-body" id="dashbody">  <!-- BODY COLOR -->
                    <!-- <form id="feedback_history_form" method="POST" action="actions/change_password.php"> -->
                    <h style="margin-top: 5px; margin-left: 10px;">See our latest trends</h>
                    
                    <div class="scrollable-content" id="inputfields" style="height: 450px; overflow-y: auto;">

                        <div class="card-body" id="cards_row1"> <!--BLUE-->
                        
                            <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">Today's data</h5>

                            <div class="d-flex justify-content-center" style="padding: 20px;"> <!-- RED -->

                                <div class="col-3 d-flex justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_feedback with column aliases
                                        $sql = "SELECT COUNT(feedback_ID) AS feedbackCount
                                                FROM tbl_feedback WHERE DATE(date) = CURDATE()";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackCount = $result['feedbackCount'];
                                    ?>
                                    
                                    <div class="card border-0" id="card1">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">New Feedbacks</h6>
                                                <img src="icons/GIF_NEWFB.gif" style="width: 1.4in; height: .80in; margin-left: 117px; margin-top: -27px;" id="newfb_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                

                                <div class="col-3 d-flex justify-content-center">
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
                                    
                                    <div class="card border-0" id="card2">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">Total Feedbacks</h6>
                                                <img src="icons/GIF_TOTALFB.gif" style="width: 1.5in; height: .80in; margin-left: 105px; margin-top: -20px;" id="totalfb_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="col-3 d-flex justify-content-center">
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
                                    
                                    <div class="card border-0" id="card3">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackAverage; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">Feedbacks a day</h6>
                                                <img src="icons/GIF_FBPERDAY.gif" style="width: 1.4in; height: .85in; margin-left: 117px; margin-top: -20px;" id="fbperday_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="col-3 d-flex justify-content-center">
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
                                    
                                    <div class="card border-0" id="card4">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $customerCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">Customers</h6>
                                                <img src="icons/GIF_CUSTOMERS.gif" style="width: 1.2in; height: .7in; margin-left: 135px; margin-top: -15px;" id="customers_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>




                            <div class="d-flex justify-content-center" style="padding: 20px;"> <!-- GREEN COLOR -->

                                <div class="col-3 d-flex justify-content-center">
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
                                    
                                    <div class="card border-0" id="card5">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $ratingCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">5-Rating</h6>
                                                <img src="icons/GIF_RATING.gif" style="width: 1.65in; height: .90in; margin-left: 90px; margin-top: -20px;" id="rating_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-3 d-flex justify-content-center">
                                </div>
                                <div class="col-3 d-flex justify-content-center">
                                </div>
                                <div class="col-3 d-flex justify-content-center">
                                </div>
                                
                            </div>

                        </div> <!--BLUE-->



                        <div class="card-body" id="cards_row1"> <!--BLUE-->

                            <!-- for pie chart -->

                        </div>



                        


                    </div>

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="dashboard_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    
                </div> <!--BODY END -->
            </div>
        </div>
    </div>

    <script>
    function openmodal_dashboard() {
        $('#modal_dashboard').modal('show');
    }
    </script>
    <!-- END DASHBOARD MODAL -- FOR VIEWING DASHBOARD -->












    <div class="body2">
        <div class="container">
            <div class="bg-transparent text-center d-flex align-items-center justify-content-center" style="height: 100vh;">
                <!-- <button type="submit" class="btn btn-dark" id="submit_feeback" data-bs-toggle="modal" data-bs-target="#modal_submit_feedback"
                    style="position: relative; font-size: 25px; width: 300px; height: 70px; border-radius: 20px;">
                    Submit Feedback
                </button> -->
            </div>
        </div>
    </div>

    <div class="body3">
        <div class="container">
            <div class="bg-transparent text-center d-flex align-items-center justify-content-center" style="height: 100vh;">
                <img src="icons/mic_wave.png" id="mic_wave" style="position: absolute; width: 33%; margin-top: -400px; filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20));">
                <img src="icons/mic_stroked.png" id="mic" style="width: 20%; margin-top: -100px; filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20));">

                <button type="button" class="btn btn-primary" id="openVoiceFeedbackModalBtn" data-bs-toggle="modal" data-bs-target="#modal_voicefeedback"
                    style="position: absolute; width: 300px; height: 70px; margin-top: 370px; margin-left: 0px; border-radius: 20px; font-size: 25px;">
                    Start Recording
                </button>

                <!-- <img src="icons/ICON_VOICEFEEDBACK.png" style="position: absolute; width: .9in; height: .9in; margin-left: 230px; margin-top: -140px; padding: -100px;" id="" alt="..."
                id="openVoiceFeedbackModalBtn" data-bs-toggle="modal" data-bs-target="#modal_voicefeedback"> -->
    
            </div>
        </div>

        
        <!-- VOICE MESSAGE MODAL -- FOR RECORDING VOICE MESSAGE -->
        <div class="modal fade" id="modal_voicefeedback" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background: linear-gradient(90deg, rgb(19, 19, 158), rgb(124, 124, 255), blue, rgb(3, 3, 33)); border-radius: 40px;">
                <div class="modal-content" style="background-color: blue; border-radius: 40px;">
                    <div class="modal-header d-flex align-items-center justify-content-center">
                        <img src="icons/ICON_MIC2.gif" style="position: absolute; width: 1.15in; margin-left: 0px; margin-top: 0px;" alt="...">

                        <h3 class="modal-title" id="voiceMessageModalLabel" style="margin-left: 130px; margin-top: 110px; color: white;"
                        ></h3>
                    </div>
                    <div class="modal-body">
                        <span id="timer" style="color: white;">00:00:00</span>
                        <audio id="audioPlayer" controls></audio>
                        <button class="btn btn-light" id="startRecording">Start</button>
                        <button class="btn btn-warning" id="pauseRecording" disabled>Pause</button>
                        <button class="btn btn-danger" id="stopRecording" disabled>Stop</button>

                        <img src="icons/ICON_TRASH.png" id="trash" style="position: absolute; width: .4in; margin-left: 220px; margin-top: 10px;
                            transition: transform 0.2s;" alt="...">
                            

                            <script>
                                let audioChunks = []; // Declare audioChunks globally

                                document.addEventListener('DOMContentLoaded', () => {
                                    const startRecordingButton = document.getElementById('startRecording');
                                    const pauseRecordingButton = document.getElementById('pauseRecording');
                                    const stopRecordingButton = document.getElementById('stopRecording');
                                    const sendRecordingButton = document.getElementById('sendRecording');
                                    const timerDisplay = document.getElementById('timer');
                                    const audioPlayer = document.getElementById('audioPlayer');
                                    const trashIcon = document.getElementById('trash');

                                    let mediaRecorder;
                                    let timerInterval;
                                    let seconds = 0;
                                    let minutes = 0;
                                    let hours = 0;

                                    startRecordingButton.addEventListener('click', startRecording);
                                    pauseRecordingButton.addEventListener('click', pauseRecording);
                                    stopRecordingButton.addEventListener('click', stopRecording);
                                    sendRecordingButton.addEventListener('click', sendRecording);
                                    trashIcon.addEventListener('click', resetRecording);

                                    function startRecording() {
                                        navigator.mediaDevices.getUserMedia({ audio: true })
                                            .then(stream => {
                                                mediaRecorder = new MediaRecorder(stream);

                                                mediaRecorder.ondataavailable = event => {
                                                    if (event.data.size > 0) {
                                                        audioChunks.push(event.data);
                                                    }
                                                };

                                                mediaRecorder.onstop = () => {
                                                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                                                    const audioUrl = URL.createObjectURL(audioBlob);
                                                    audioPlayer.src = audioUrl;
                                                    resetButtons();
                                                };

                                                mediaRecorder.start();
                                                startRecordingButton.disabled = true;
                                                pauseRecordingButton.disabled = false;
                                                stopRecordingButton.disabled = false;
                                                sendRecordingButton.disabled = true;

                                                // Start the timer
                                                timerInterval = setInterval(updateTimer, 1000);
                                            })
                                            .catch(err => console.error('Error accessing microphone:', err));
                                    }

                                    function pauseRecording() {
                                        if (mediaRecorder && mediaRecorder.state === 'recording') {
                                            mediaRecorder.pause();
                                            pauseRecordingButton.textContent = 'Resume';
                                            stopRecordingButton.disabled = false;
                                            clearInterval(timerInterval);
                                        } else if (mediaRecorder && mediaRecorder.state === 'paused') {
                                            mediaRecorder.resume();
                                            pauseRecordingButton.textContent = 'Pause';
                                            stopRecordingButton.disabled = false;
                                            // Resume the timer
                                            timerInterval = setInterval(updateTimer, 1000);
                                        }
                                    }

                                    function stopRecording() {
                                        if (mediaRecorder && (mediaRecorder.state === 'recording' || mediaRecorder.state === 'paused')) {
                                            mediaRecorder.stop();
                                        }
                                    }

                                    function sendRecording() {
                                        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                                        const formData = new FormData();
                                        formData.append('audioData', audioBlob, 'voice_message.wav');

                                        fetch('actions/store_audio.php', {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(response => {
                                            console.log('Response Status:', response.status);
                                            return response.text();
                                        })
                                        .then(message => {
                                            console.log('Server Message:', message);
                                            // Optionally, you can show a success message to the user
                                        })
                                        .catch(error => {
                                            console.error('Error sending audio data:', error);
                                            // Handle the error appropriately
                                        });
                                    }

                                    function updateTimer() {
                                        seconds++;
                                        if (seconds === 60) {
                                            seconds = 0;
                                            minutes++;
                                            if (minutes === 60) {
                                                minutes = 0;
                                                hours++;
                                            }
                                        }
                                        timerDisplay.textContent = formatTime(hours, minutes, seconds);
                                    }

                                    function formatTime(hours, minutes, seconds) {
                                        return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
                                    }

                                    function pad(number) {
                                        return (number < 10) ? `0${number}` : number;
                                    }

                                    function resetButtons() {
                                        startRecordingButton.disabled = false;
                                        pauseRecordingButton.disabled = true;
                                        stopRecordingButton.disabled = true;
                                        sendRecordingButton.disabled = false;
                                        clearInterval(timerInterval);
                                        resetTimer();
                                    }

                                    function resetTimer() {
                                        seconds = 0;
                                        minutes = 0;
                                        hours = 0;
                                        timerDisplay.textContent = '00:00:00';
                                    }

                                    function resetRecording() {
                                        if (mediaRecorder && (mediaRecorder.state === 'recording' || mediaRecorder.state === 'paused')) {
                                            mediaRecorder.stop();
                                        }
                                        audioChunks = [];
                                        audioPlayer.src = '';
                                        resetButtons();
                                    }
                                });

                                // Declare openmodal_voicefeedback outside of the DOMContentLoaded event
                                function openmodal_voicefeedback() {
                                    $('#modal_voicefeedback').modal('show');
                                }
                            </script>


                        <button class="btn btn-primary" id="sendRecording" style="border: 1px solid lightblue;" disabled>Send Voice Feedback</button>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function openmodal_voicefeedback() {
                $('#modal_voicefeedback').modal('show');
            }

            function sendRecording() {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                const formData = new FormData();
                formData.append('audioData', audioBlob, 'voice_message.wav');

                fetch('actions/store_audio.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response Status:', response.status);
                    return response.text();
                })
                .then(message => {
                    console.log('Server Message:', message);
                    // Optionally, you can show a success message to the user
                })
                .catch(error => {
                    console.error('Error sending audio data:', error);
                    // Handle the error appropriately
                });
            }
        </script>
        <!-- END VOICE MESSAGE MODAL -- FOR RECORDING VOICE MESSAGE -->


    </div>

    


</body>



<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>About Us</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra bibendum nulla, vitae dapibus felis tempor in.</p>
      </div>
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <ul class="list-unstyled">
          <li>Phone: +123456789</li>
          <li>Email: info@example.com</li>
          <li>Address: 123 Main Street, City, Country</li>
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
        <p>&copy; 2024 Your Company. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

</html>

<script>
    function to_navigation() {
$.post("pages/nav/nav.php", {},function (data) {
      $("#contents").html(data);  
    });
}  
</script>


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


















