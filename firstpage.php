<?php
include "connection.php";

$sql = "SELECT image_dir FROM images WHERE id IN (14, 15)";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
    $conn->close();
    exit;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiaBuddy</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Lobster&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #FF6F61;
            color: #f8f9fa;
        }
        .container {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .header {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: bold;
            font-family: 'Lobster', cursive;
            color: #FF6F61;
        }
        .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        .box {
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .box img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .box-text {
            margin-top: 15px;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
        @media (max-width: 600px) {
            .header {
                font-size: 2em;
            }
            .box-text {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Who are you?</div>
        <div class="box-container">
            <?php
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<div class="box" onclick="redirectTo(\'login.php\')">';
                echo '<img src="' . $row['image_dir'] . '" alt="User Image">';
                echo '<div class="box-text">User</div>';
                echo '</div>';

                $row = $result->fetch_assoc();
                echo '<div class="box" onclick="redirectTo(\'ADlogin.php\')">';
                echo '<img src="' . $row['image_dir'] . '" alt="Admin Image">';
                echo '<div class="box-text">Admin</div>';
                echo '</div>';
            } else {
                echo '<p>No images found in the database.</p>';
            }
            ?>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>