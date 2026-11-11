<?php
include "connection.php";

if(isset($_POST['name']) || isset($_POST['password'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = $conn->query($sql);
    $user_data = $result->fetch_array();

    if($result) {
        if($user_data) {
            do {
                if($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: mainpage1.php");
                    die;
                }
            } while($row = $result->fetch_array());

            echo "<script>alert('Wrong password!');</script>";
        } else {
            echo "<script>alert('Wrong username and password');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiaBuddy - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E8F5E2;
            justify-content: center;
            align-items: center;
            height: 100vh;
            display: flex;
        }
        .login-container {
            background-color: #FF6F61;
            padding: 45px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 450px;
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: white;
            color: black;
            cursor: pointer;
            width: 100%;
            padding: 15px;
            font-size: 18px;
        }
        button:hover {
            background-color: #FF6F61;
        }
        a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        a:hover {
            color: #E8F5E2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>User Login</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <a href="signup.php">Don't have an account? Sign up here!</a>
        </form>
    </div>
</body>         
</html>