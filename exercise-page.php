<?php
include "connection.php";


$exercise = [
    [
        'type' => 'Gestational Diabetes',
        'frequency' => 'Frequency: 4-5 times per week',
        'duration' => 'Duration: 30-60 minutes per session',
        'exercise_details' => 'Type of Exercise:
        
        Aerobic Activities: Walking, swimming, stationary cycling
        
        Strength Training: Bodyweight exercises, resistance bands
        
        Flexibility and Relaxation: Prenatal yoga or stretching',
    ],
    [
        'type' => 'Type 1 Diabetes',
        'frequency' => 'Frequency: 5-7 times per week',
        'duration' => 'Duration: 30-60 minutes per session',
        'exercise_details' => 'Type of Exercise: Aerobic Activities: Running, brisk walking, HIIT
        
        Strength Training: Weight lifting, resistance training
        
        Flexibility and Balance: Yoga or Pilates
        Note: Monitor blood sugar levels to avoid hypoglycemia.',
    ],
    [
        'type' => 'Type 2 Diabetes',
        'frequency' => 'Frequency: 5-7 times per week',
        'duration' => 'Duration: 150 minutes of moderate-intensity aerobic activity per week',
        'exercise_details' => 'Type of Exercise: Aerobic Activities: Walking, cycling, swimming
        
        Strength Training: Bodyweight exercises, resistance training
        
        Flexibility and Balance: Stretching, Tai Chi, or yoga',
    ],
];

foreach ($exercise as $plan) {
    $type = $conn->real_escape_string($plan['type']);
    $frequency = $conn->real_escape_string($plan['frequency']);
    $duration = $conn->real_escape_string($plan['duration']);
    $exercise_details = $conn->real_escape_string($plan['exercise_details']);

    $sql = "INSERT INTO exercises (type, frequency, duration, exercise_details) 
            VALUES ('$type', '$frequency', '$duration', '$exercise_details')";

    if ($conn->query($sql) === TRUE) {
    
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diabuddy</title>
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
            font-family: 'Lobster', cursive;
            color: white;
            padding: 6px;
            text-align: center;
            position: relative;
            animation: slideInFromTop 1s ease-in-out;
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
            color: white;
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
        .slideshow-container {
            position: relative;
            max-width: 800px; 
            margin: auto;
            text-align: center;
            font-size: 30px; 
        }
        .mySlides-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .mySlides {
            margin: 10px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(1, 1, 1, 0.2);
        }
        .mySlides iframe {
            width: 300px;
            height: 200px;
            border: none;
        }
        .mySlides {
            display: none;
        }
        .box-image {
            max-width: 200%; 
            height: auto; 
        }
        
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
        }
        .active, .dot:hover {
            background-color: #717171;
        }
        .container, .slideshow-container {
            display: flex; 
            justify-content: center; 
            flex-wrap: wrap; 
        }
        .box {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            margin: 10px; 
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }
        .box:hover{
            transition: transform 0.3s ease;
            transform: scale(0.9);
            z-index: 2; 
        }
        h2 {
            text-align: center;
            color: #333;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: white;
            color: #FF6F61; 
            position: relative;
            bottom: 0;
            width: 100%;
            font-family: 'Lobster', cursive;
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
    <main>
        <div class="slideshow-container">
            <div class="mySlides fade">
                <a href="https://www.youtube.com/watch?v=fUdh6o19LsU" target="_blank">
                    <img src="https://img.youtube.com/vi/fUdh6o19LsU/0.jpg" alt="Thumbnail 1" class="box-image">
                </a>
            </div>
            <div class="mySlides fade">
                <a href="https://www.youtube.com/watch?v=6MnbaUBO_DY" target="_blank">
                    <img src="https://img.youtube.com/vi/6MnbaUBO_DY/0.jpg" alt="Thumbnail 2" class="box-image">
                </a>
            </div>
            <div class="mySlides fade">
                <a href="https://www.youtube.com/watch?v=ZCFUkkpGtlQ" target="_blank">
                    <img src="https://img.youtube.com/vi/ZCFUkkpGtlQ/0.jpg" alt="Thumbnail 3" class="box-image">
                </a>
            </div>
    
        </div>
        <br>
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
            <span class="dot" onclick="currentSlide(3)"></span> 
        </div>
        <div class="container">
            <div class="box">
                <h2>Gestational Diabetes</h2>
                <p><strong>Frequency:</strong> 4-5 times per week</p>
                <br>
                <p><strong>Duration:</strong> 30-60 minutes per session</p>
                <br>
                <p><strong>Type of Exercise:</strong></p>
                <br>
                <ul>
                    <li><strong>Aerobic Activities:</strong> Walking, swimming, stationary cycling</li>
                    <br>
                    <li><strong>Strength Training:</strong> Bodyweight exercises, resistance bands</li>
                    <br>
                    <li><strong>Flexibility and Relaxation:</strong> Prenatal yoga or stretching</li>
                </ul>
            </div>
            <br>
            <div class="box">
                <h2>Type 1 Diabetes</h2>
                <p><strong>Frequency:</strong> 5-7 times per week</p>
                <br>
                <p><strong>Duration:</strong> 30-60 minutes per session</p>
                <br>
                <p><strong>Type of Exercise:</strong></p>
                <ul>
                    <li><strong>Aerobic Activities:</strong> Running, brisk walking, HIIT</li>
                    <br>
                    <li><strong>Strength Training:</strong> Weight lifting, resistance training</li>
                    <br>
                    <li><strong>Flexibility and Balance:</strong> Yoga or Pilates</li>
                </ul>
                <p><strong>Note:</strong> Monitor blood sugar levels to avoid hypoglycemia.</p>
            </div>
            <br>
            <div class="box">
                <h2>Type 2 Diabetes</h2>
                <p><strong>Frequency:</strong> 5-7 times per week</p>
                <br>
                <p><strong>Duration:</strong> 150 minutes of moderate-intensity aerobic activity per week</p>
                <br>
                <p><strong>Type of Exercise:</strong></p>
                <ul>
                    <li><strong>Aerobic Activities:</strong> Walking, cycling, swimming</li>
                    <br>
                    <li><strong>Strength Training:</strong> Bodyweight exercises, resistance training</li>
                    <br>
                    <li><strong>Flexibility and Balance:</strong> Stretching, Tai Chi, or yoga</li>
                </ul>
            </div>
        </div>
    </main>
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

            let slideIndex = 1;
            showSlides(slideIndex);
            function plusSlides(n) {
                showSlides(slideIndex += n);
            }
            function currentSlide(n) {
                showSlides(slideIndex = n);
            }
            function showSlides(n) {
                let slides = document.getElementsByClassName("mySlides");
                let dots = document.getElementsByClassName("dot");
                if (n > slides.length) { slideIndex = 1; }
                if (n < 1) { slideIndex = slides.length; }
                for (let i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (let i = 0; dots && i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex - 1].style.display = "block";
                if (dots && dots[slideIndex - 1]) {
                    dots[slideIndex - 1].className += " active";
                }
                setTimeout(() => {
                    plusSlides(1);
                }, 3000);
            }
        });
    </script>
</body>
</html>