<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Your Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #E8F5F2;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden; 
        }
        header {
            background-color: #FF6F61;
            color: white;
            padding: 6px;
            text-align: center;
            position: relative;
            animation: slideInFromTop 1s ease-in-out;
            font-family: 'Lobster', cursive;
        }
        @keyframes slideInFromTop {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        header img.logo {
            position: absolute;
            left: 30px;
            top: 2%;
            transform: translateY(-30%);
            transform: translateX(-20%);
            height: 130px;
            transition: transform 3s ease-in-out, width 3s ease-in-out, height 3s ease-in-out;
            cursor: pointer;
        }
        .logo {
            display: inline-block;
            transition: transform 0.3s ease;
        }
        .logo.expand {
            animation: expandLogo 3s forwards;
        }
        @keyframes expandLogo {
            0% {
                top: 10px;
                left: 20px;
                height: 50px;
                width: auto;
                transform: translate(0, 0) scale(1);
            }
            100% {
                top: 150%;
                left: 50%;
                height: 130vh;
                width: auto;
                transform: translate(-50%, -50%) scale(1);
                z-index: 9999;
            }
        }
        a {
            color: black;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease; 
            display: inline-block; 
        }
        a:hover {
            transform: scale(1.1);
            z-index: 2; 
        }
        main {
            padding: 20px;
        }
        nav {
            background-color: #FF6F61; 
            padding: 20px;
            text-align: center;
        }
        .nav-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: inline-flex;
            justify-content: center;
        }
        .nav-item {
            margin: 0 15px;
        }
        .nav-link {
            text-decoration: none;
            color: white; 
        }
        .nav-box {
            background-color: white;
            color: #FF6F61; 
            padding: 10px;
            width: 150px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .nav-box:hover {
            background-color: #FF6F61; 
            color: white;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        @keyframes slideIn {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }
        .content {
            padding: 20px;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        h2 {
            color: #FF6F61;
            font-family: 'Lobster', cursive;
        }
        p {
            font-family: 'Lobster', cursive;
        }
        .video-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .video {
            margin: 10px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .video iframe {
            width: 300px;
            height: 200px;
            border: none;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: white;
            color: #FF6F61; 
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .container {
            display: flex;             
            justify-content: center;  
            gap: 20px;                 
            margin-top: 50px;
        }
        .box {
            width: 400px;              
            height: 350px;            
            perspective: 1000px;  
            border-radius: 8px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            background-color: black; 
            padding: 20px;
        }
        .flip-container {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .flip-container:hover {
            transform: scale(1.05); 
            z-index: 2; 
        }
        .flipper {
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            position: absolute;
            backface-visibility: hidden;
        }
        .front {
            background: black;
            color: white; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%; 
            padding: 0; 
        }
        .front img {
            width: 100%;
            height: 100%;              
            object-fit: cover; 
            border-radius: 8px; 
        }
        .back {
            background-color: #FF6F61; 
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            transform: rotateY(180deg);
        }
        .link {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            background: rgba(0, 0, 0, 0.6);
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo5.png" alt="DiaBuddy Logo" class="logo" id="logo">
        <h1><a href="mainpage1.php">DiaBuddy: Your Diabetes Manager</a></h1>
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href="log_data.php" class="nav-link"><div class="nav-box"><h3>Log Data</h3></div></a></li>
            <li class="nav-item"><a href="view_past_data.php" class="nav-link"><div class="nav-box"><h3>View Your Data</h3></div></a></li>
            <li class="nav-item"><a href="meal-page.php" class="nav-link"><div class="nav-box"><h3>Meal Plan</h3></div></a></li>
            <li class="nav-item"><a href="exercise-page.php" class="nav-link"><div class="nav-box"><h3>Exercise</h3></div></a></li>
            <li class="nav-item"><a href="contact-us.php" class="nav-link"><div class="nav-box"><h3>Contact Us</h3></div></a></li>
            <li class="nav-item"><a href="login.php" class="nav-link"><div class="nav-box"><h3>Log Out</h3></div></a></li>
        </ul>
    </nav>
    </header>
    <div class="content">
        <section id="nutrition">
            <h2>About Us</h2>
            <p>Welcome to DiaBuddy, your comprehensive diabetes management solution. DiaBuddy is designed to help you effectively manage your diabetes through a variety of powerful features. Our platform allows you to log and save crucial data such as insulin dosages and blood sugar levels, which are then used to generate personalized meal plans and exercise routines tailored to your type of diabetes. We also provide detailed graphs to help you keep track of your health metrics over time. Additionally, our notifications feature ensures you never miss a dosage or measurement by reminding you at the specific times you set. With DiaBuddy, managing diabetes becomes simpler and more intuitive, helping you maintain a healthier lifestyle with ease.</p>
        </section>

        <section id="exercise">
            <h2>Exercise Guidelines</h2>
            <p>Regular physical activity can help improve your overall health. Aim for at least 150 minutes of moderate aerobic activity or 75 minutes of vigorous activity each week.</p>
        </section>

        <section id="exercise">
            <h2>Meal Plan</h2>
            <p>Finding a meal plan that is detailed and beneficial can be tricky. Following the Meal Plan page, you can find all of our meal plans for each type of diabetes and if you want to find one specifically for you, press the the button, Generate Meal Plan Choices.</p>
        </section>
        <h2>Helpful Videos</h2>
        <div class="container">
            <div class="box">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front" onclick="window.location.href='https://www.youtube.com/watch?v=6edXHilI3aw';">
                            <img src="https://img.youtube.com/vi/6edXHilI3aw/hqdefault.jpg" alt="Video Thumbnail 1">
                            <p>How To Take An Insulin Dosage</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front" onclick="window.location.href='https://www.youtube.com/watch?v=SQ_h3EVhqfw';">
                            <img src="https://img.youtube.com/vi/SQ_h3EVhqfw/hqdefault.jpg" alt="Video Thumbnail 2">
                            <p>How To Measure Your Blood Sugar Level</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front" onclick="window.location.href='https://www.youtube.com/watch?v=660-WfS3yW0';">
                            <img src="https://img.youtube.com/vi/660-WfS3yW0/hqdefault.jpg" alt="Video Thumbnail 3">
                            <p>Precautions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <section id="contact">
            <h2>Contact Us</h2>
            <p>If you have any questions or need further information, please feel free to <a href="contact-us.php">contact us</a>.</p>
        </section>
    </div>
    <footer>
        <p>For more info about this program, please refer to the following:</p>
        <p>DiaBuddy is a program designed for people who have diabetes and struggle with keeping track of the many calculations involved in the process, such as insulin dosages, blood glucose levels, and in need of support. DiaBuddy doesn't just keep track of your data, but also provides a detailed meal and exercise plan based on your data.</p>
        <p>&copy; 2024 Diabetes Management Program</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logo = document.getElementById('logo');
            if (logo) {
                logo.addEventListener('click', function() {
                    logo.classList.add('expand');
                    setTimeout(() => {
                        window.location.href = 'info.php';
                    }, 3000);
                });
            }
        });
    </script>
</body>         
</html>