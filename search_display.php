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
            $firstName = $user['firstName'];
            $middleName = $user['middleName'];
            $lastName = $user['lastName'];
            $street = $user['street'];
            $barangay = $user['barangay'];
            $municipality = $user['municipality'];
            $province = $user['province'];
            $zipcode = $user['zipcode'];
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
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--FOR PIE CHART-->
    <title>Nasara - Admin</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }
    .table-container {
        width: 80%;
        margin: 0 auto;
        margin-top: 20px;
        max-height: 700px; /* Set a maximum height */
        overflow-y: auto; /* Add vertical scrollbar */
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:nth-child(odd) {
        background-color: #ffffff;
    }
    .navbar {
        margin-bottom: 20px;
    }
    #icon_profile {
        cursor: pointer;
    }
</style>

</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/admin/style_ad.css">

   <!-- Navigation bar -->
   <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <img src="icons/NASARA_LOGO_WHITE_PNG.png" class="img-fluid" id="NASARA_LOGO" alt="">
        
        <form method="post" action="search_display.php" style="width: 300px; margin-left: 950px;">
            <input class="form-control me-2" type="text" name="search" placeholder="Search" aria-label="Search" style="width: 250px;">
            <button class="btn btn-light" type="submit" name="submit" style="position: absolute; margin-left: 252px; margin-top: -38px;"><i class="fas fa-search"></i></button>
        </form>

        <img src="images_admin/<?php echo $adminimage; ?>" id="icon_profile" class="img-fluid zoomable-image rounded-square" onclick="to_adminacc()">
    </nav>

    <button type="button" class="btn btn-secondary" style="width: 40px; height: 40px; margin-top: 20px; margin-left: 105px; border-radius: 50%;"
        href="#" onclick="window.location.href = 'admin_main.php';">
        <i class="fas fa-arrow-left" style="font-size: 20px;"></i>
    </button>

    


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nasara";
try {
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["submit"])) {
        $str = $_POST["search"];
    
        $sth = $con->prepare("SELECT * FROM `tbl_customer_info` WHERE 
        customer_ID LIKE :name
        OR firstName LIKE CONCAT('%', :name, '%')
        OR lastName LIKE CONCAT('%', :name, '%')
        OR street LIKE CONCAT('%', :name, '%')
        OR barangay LIKE CONCAT('%', :name, '%')
        OR municipality LIKE CONCAT('%', :name, '%')
        OR province LIKE CONCAT('%', :name, '%')
        OR zipcode LIKE CONCAT('%', :name, '%')
        OR birthDate LIKE CONCAT('%', :name, '%')
        OR gender LIKE CONCAT('%', :name, '%')
        OR phoneNumber LIKE CONCAT('%', :name, '%')
        OR email LIKE CONCAT('%', :name, '%')
        OR customer_ID IN (SELECT customer_ID FROM `tbl_feedback` WHERE 
            feedback_ID LIKE CONCAT('%', :name, '%')
            OR products LIKE CONCAT('%', :name, '%')
            OR services LIKE CONCAT('%', :name, '%')
            OR convenience LIKE CONCAT('%', :name, '%')
            OR rating LIKE CONCAT('%', :name, '%')
            OR date LIKE CONCAT('%', :name, '%'))
        OR customer_ID IN (SELECT customer_ID FROM `tbl_audio_feedback` WHERE 
            audio_ID LIKE CONCAT('%', :name, '%')
            OR audio LIKE CONCAT('%', :name, '%')
            OR dateAdded LIKE CONCAT('%', :name, '%'))");
        $sth->bindParam(':name', $str, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_OBJ);
        $sth->execute();
    
        // Check if any rows are returned
        if ($sth->rowCount() > 0) {
            ?>
            <div class="table-container">
    <h2>Customer Information</h2>
    <table>
        <tr>
            <th>Customer ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Street</th>
            <th>Barangay</th>
            <th>Municipality</th>
            <th>Province</th>
            <th>Zip Code</th>
            <th>Birth Date</th>
            <th>Gender</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Date Added</th>
            <th>Date Modified</th>
            <th>Image</th>
        </tr>
        <?php while ($row = $sth->fetch()) { ?>
            <tr onclick="window.location='view_customer.php?customer_id=<?php echo htmlspecialchars($row->customer_ID); ?>';">
                <td><?php echo htmlspecialchars($row->customer_ID); ?></td>
                <td><?php echo htmlspecialchars($row->firstName); ?></td>
                <td><?php echo htmlspecialchars($row->middleName); ?></td>
                <td><?php echo htmlspecialchars($row->lastName); ?></td>
                <td><?php echo htmlspecialchars($row->street); ?></td>
                <td><?php echo htmlspecialchars($row->barangay); ?></td>
                <td><?php echo htmlspecialchars($row->municipality); ?></td>
                <td><?php echo htmlspecialchars($row->province); ?></td>
                <td><?php echo htmlspecialchars($row->zipcode); ?></td>
                <td><?php echo htmlspecialchars($row->birthDate); ?></td>
                <td><?php echo htmlspecialchars($row->gender); ?></td>
                <td><?php echo htmlspecialchars($row->phoneNumber); ?></td>
                <td><?php echo htmlspecialchars($row->email); ?></td>
                <td><?php echo htmlspecialchars($row->dateAdded); ?></td>
                <td><?php echo htmlspecialchars($row->dateModified); ?></td>
                <td><?php echo htmlspecialchars($row->image); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>


            <?php
                // Search in tbl_feedback
                $sth_feedback = $con->prepare("SELECT * FROM `tbl_feedback` WHERE 
                customer_ID = :customer_ID
                OR feedback_ID LIKE CONCAT('%', :name, '%')
                OR products LIKE CONCAT('%', :name, '%')
                OR services LIKE CONCAT('%', :name, '%')
                OR convenience LIKE CONCAT('%', :name, '%')
                OR rating LIKE CONCAT('%', :name, '%')
                OR date LIKE CONCAT('%', :name, '%')");
                $sth_feedback->bindParam(':customer_ID', $customer_ID, PDO::PARAM_INT);
                $sth_feedback->bindParam(':name', $str, PDO::PARAM_STR);
                $sth_feedback->setFetchMode(PDO::FETCH_OBJ);
                $sth_feedback->execute();
            ?>
            <div class="table-container">
                <h2>Written Feedbacks</h2>
                <table>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Products</th>
                        <th>Services</th>
                        <th>Convenience</th>
                        <th>Rating</th>
                        <th>Date</th>
                        <th>Customer ID</th>
                    </tr>
                    <?php while ($row_feedback = $sth_feedback->fetch()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row_feedback->feedback_ID); ?></td>
                        <td><?php echo htmlspecialchars($row_feedback->products); ?></td>
                        <td><?php echo htmlspecialchars($row_feedback->services); ?></td>
                        <td><?php echo htmlspecialchars($row_feedback->convenience); ?></td>
                        <td><?php echo htmlspecialchars($row_feedback->rating); ?></td>
                        <td><?php echo htmlspecialchars($row_feedback->date); ?></td>
                        <td><?php echo htmlspecialchars($row_feedback->customer_ID); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>

            <!-- After displaying written feedbacks -->
            <?php
                // Search in tbl_audio_feedback
                $sth_audio_feedback = $con->prepare("SELECT * FROM `tbl_audio_feedback` WHERE 
                customer_ID = :customer_ID
                OR audio_ID LIKE CONCAT('%', :name, '%')
                OR audio LIKE CONCAT('%', :name, '%')
                OR dateAdded LIKE CONCAT('%', :name, '%')");
                $sth_audio_feedback->bindParam(':customer_ID', $customer_ID, PDO::PARAM_INT);
                $sth_audio_feedback->bindParam(':name', $str, PDO::PARAM_STR);
                $sth_audio_feedback->setFetchMode(PDO::FETCH_OBJ);
                $sth_audio_feedback->execute();
            ?>
            <div class="table-container">
                <h2>Audio Feedbacks</h2>
                <table>
                    <tr>
                        <th>Audio ID</th>
                        <th>Audio</th>
                        <th>Date Added</th>
                        <th>Customer ID</th>
                    </tr>
                    <?php while ($row_audio_feedback = $sth_audio_feedback->fetch()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row_audio_feedback->audio_ID); ?></td>
                        <td>
                            <?php
                            $audio_url = "http://localhost/nasara/audios/" . htmlspecialchars($row_audio_feedback->audio);
                            ?>
                            <audio controls>
                                <source src="<?php echo $audio_url; ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td><?php echo htmlspecialchars($row_audio_feedback->dateAdded); ?></td>
                        <td><?php echo htmlspecialchars($row_audio_feedback->customer_ID); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>

            <?php
        } else {
            echo "Customer does not exist";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

    <div class="row" style="margin: 30px;"></div>
</body>
</html>

<script>
    function to_adminfeedbacks() {
        window.location.href = 'admin_feedbacks.php';
    }
    function to_adminacc() {
        window.location.href = 'admin_account.php';
    }
</script>
