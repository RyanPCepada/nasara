<?php
// edit_feedback.php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM tbl_feedback WHERE feedback_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $feedback = $stmt->fetch();

    if (!$feedback) {
        echo "Feedback not found.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $products = $_POST['products'];
    $services = $_POST['services'];
    $convenience = $_POST['convenience'];
    $rating = $_POST['rating'];

    $sql = "UPDATE tbl_feedback SET products = :products, services = :services, convenience = :convenience, rating = :rating WHERE feedback_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':products', $products);
    $stmt->bindParam(':services', $services);
    $stmt->bindParam(':convenience', $convenience);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Updated the feedback", $customerID]);

    if ($stmt->execute()) {
        header("Location: account_main.php");
        exit;
    } else {
        echo "Failed to update feedback.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .container input[type="text"],
        .container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Feedback</h1>
        <form method="POST" action="edit_feedback.php">
            <input type="hidden" name="id" value="<?php echo $feedback['feedback_ID']; ?>">
            <label>Products:</label>
            <input type="text" name="products" value="<?php echo htmlspecialchars($feedback['products']); ?>"><br>
            <label>Services:</label>
            <input type="text" name="services" value="<?php echo htmlspecialchars($feedback['services']); ?>"><br>
            <label>Convenience:</label>
            <input type="text" name="convenience" value="<?php echo htmlspecialchars($feedback['convenience']); ?>"><br>
            <label>Rating:</label>
            <input type="number" name="rating" value="<?php echo htmlspecialchars($feedback['rating']); ?>" min="1" max="5"><br>
            <input type="submit" value="Update Feedback">
        </form>
    </div>
</body>
</html>
