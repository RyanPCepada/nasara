<!DOCTYPE html>
<html>
<head>
    <title>Search Bar using PHP</title>
</head>
<body>
<!-- 
<form method="post">
<label>Search</label>
<input type="text" name="search">
<input type="submit" name="submit">
</form> -->

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
        
        // Search in tbl_customer_info
        $sth = $con->prepare("SELECT * FROM `tbl_customer_info` WHERE firstName = :name OR lastName = :name");
        $sth->bindParam(':name', $str, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_OBJ);
        $sth->execute();
        
        if ($row = $sth->fetch()) {
            $customer_ID = $row->customer_ID;
            ?>
            <br><br><br>
            <h2>Customer Information</h2>
            <table border="1">
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
                <tr>
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
            </table>
            <?php
            
            // Search in tbl_feedback
            $sth_feedback = $con->prepare("SELECT * FROM `tbl_feedback` WHERE customer_ID = :customer_ID");
            $sth_feedback->bindParam(':customer_ID', $customer_ID, PDO::PARAM_INT);
            $sth_feedback->setFetchMode(PDO::FETCH_OBJ);
            $sth_feedback->execute();
            ?>
            <br><br><br>
            <h2>Written Feedbacks</h2>
            <table border="1">
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
            <?php
            
            // Search in tbl_audio_feedback
            $sth_audio_feedback = $con->prepare("SELECT * FROM `tbl_audio_feedback` WHERE customer_ID = :customer_ID");
            $sth_audio_feedback->bindParam(':customer_ID', $customer_ID, PDO::PARAM_INT);
            $sth_audio_feedback->setFetchMode(PDO::FETCH_OBJ);
            $sth_audio_feedback->execute();
            ?>
            <br><br><br>
            <h2>Audio Feedbacks</h2>
            <table border="1">
                <tr>
                    <th>Audio ID</th>
                    <th>Audio</th>
                    <th>Date Added</th>
                    <th>Customer ID</th>
                </tr>
                <?php while ($row_audio_feedback = $sth_audio_feedback->fetch()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row_audio_feedback->audio_ID); ?></td>
                    <td><?php echo htmlspecialchars($row_audio_feedback->audio); ?></td>
                    <td><?php echo htmlspecialchars($row_audio_feedback->dateAdded); ?></td>
                    <td><?php echo htmlspecialchars($row_audio_feedback->customer_ID); ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo "Customer does not exist";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


</body>
</html>
