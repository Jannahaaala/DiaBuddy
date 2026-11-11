<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $conpass = $_POST['confirmpassword'];

    if ($password !== $conpass) {
        echo "Passwords do not match.";
        exit();
    }
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E8F5E2;
            justify-content: center;
            align-items: center;
            height: 100vh;
            display: flex;
        }
        .signup-container {
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
        input[type="text"], input[type="email"], input[type="password"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-field {
            width: 100%;
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 18px; 
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
    <div class="signup-container">
        <h1>Sign Up</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class= "input-field" required>
           <br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="input-field" required>
           <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="input-field" required>
            <br>

            <label for="confirmpassword">Confirm Password:</label>
            <input type="password" id="confirmpassword" name="confirmpassword" class="input-field" required>
            <br>

            <button type="submit">Sign Up</button>
            <br>
            <a href="login.php">Go back to login page</a>
        </form>
    </div>
    
    <script>
        function signup()
        {
            window.location.href='mainpage1.php'
        }
        </script>

</body>
</html>