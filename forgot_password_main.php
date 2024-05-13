<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 300px;
    }

    h2 {
      color: #333;
    }

    p {
      color: #666;
      margin-top: 5px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      box-sizing: border-box;
    }

    button {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Forgot Password</h2>
    <p>Enter your email address below and we'll send you a link to reset your password.</p>

    <form action="#" method="post">
      <input type="email" name="email" placeholder="Your Email" required>
      <button type="submit">Reset Password</button>
    </form>

    <p><a  onclick="to_login()" href="#">Back to Login</a></p>
  </div>

</body>
</html>

<script>
    function to_login() {
      window.location.href = 'login_main.php';
    }
</script>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="">
    <title>Forgot Password</title>
</head>
<body>
    <div>
        <h1 style="font-size: 180px; margin-top: -20px; position: absolute;">BUNGAWON<br/>KANG<br/>DAKO</h1>
        <button onclick="to_login()" style="position: absolute; margin-top: 250px; margin-left: 750px; width: 500px; height: 250px; font-size: 100px;">Back to Login</button>
    </div>
</body>
</html>

<script>
    function to_login() {
      window.location.href = 'login_main.php';
    }
</script> -->