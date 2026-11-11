<?php
include "connection.php";

$sql = "SELECT image_dir FROM images LIMIT 13";
$result = $conn->query($sql);
$images = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_dir'];
    }
}
$images = array_slice($images, 3);

session_start();
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
            left: 12px;
            top: -2%;
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
                top: 200%;
                left: 50%;
                height: 130vh;
                width: auto;
                transform: translate(-50%, -50%) scale(1);
                z-index: 9999;
            }
        }
        label {
            display: block;
            margin-top: 10px;
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
        h1 {
            text-align: center;
            background-color: white;
            padding: 10px;
            color: #FF6F61;
            font-weight: bold;
            font-size: 24px;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px;
            border-bottom: 2px solid #FF6F61;
        }
        form {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            justify-content: center;
            text-align: center;
            margin: 30px auto;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            transition: transform 0.3s ease;
        }
        .box {
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            width: calc(30% - 20px);
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
        }
        .box:hover {
            transform: scale(0.9);
            z-index: 2;
        }
        .box img {
            width: 100%;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .track-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #FF6F61;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .track-button:hover {
            background-color: #FF4F41;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo5.png" alt="DiaBuddy Logo" class="logo" id="logo">
        <a href="mainpage1.php">DiaBuddy: Your Diabetes Manager</a>
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
        <form>
            <label for="selectedDate">Select a date to generate meal plans:</label>
            <input type="date" id="selectedDate" required>
            <br><br>
            <button type="button" class="track-button" onclick="filterMealPlans()">Generate Meal Plan Choices</button>
        </form>
        <h1>Meal Plans for Selected Date:</h1>
        <div class="container">
            <?php
            $selectedDate = isset($_POST['selectedDate']) ? $_POST['selectedDate'] : null;

            $sql = "SELECT DISTINCT recipes.meal_name, recipes.recipe, recipes.calories, recipes.carbohydrates, recipes.protein,
                            recipes.sugar, recipes.fiber, recipes.meal_type, recipes.suitable_for 
                    FROM recipes
                    INNER JOIN viewdata ON recipes.suitable_for = viewdata.typeofdiabetes";

            if ($selectedDate) {
                $sql .= " WHERE viewdata.Date = ?";
            }

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

            if ($selectedDate) {
                $stmt->bind_param("s", $selectedDate);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $imageIndex = 0;
                while ($row = $result->fetch_assoc()) {
                    $meal_name = htmlspecialchars($row['meal_name']);
                    $recipe = htmlspecialchars($row['recipe']);
                    $calories = htmlspecialchars($row['calories']);
                    $carbohydrates = htmlspecialchars($row['carbohydrates']);
                    $protein = htmlspecialchars($row['protein']);
                    $sugar = htmlspecialchars($row['sugar']);
                    $fiber = htmlspecialchars($row['fiber']);
                    $mealType = htmlspecialchars($row['meal_type']);
                    $suitableFor = htmlspecialchars($row['suitable_for']);
                    $imageSrc = isset($images[$imageIndex]) ? htmlspecialchars($images[$imageIndex]) : "default-image.png";
                    $imageIndex++;

                    echo <<<HTML
                    <div class="box">
                        <h3>$meal_name</h3>
                        <img src="$imageSrc" alt="$meal_name">
                        <p><strong>Suitable for:</strong> $suitableFor</p>
                        <p><strong>Meal Type:</strong> $mealType</p>
                        <p><strong>Recipe:</strong> $recipe</p>
                        <p><strong>Calories:</strong> $calories</p>
                        <p><strong>Carbs:</strong> $carbohydrates</p>
                        <p><strong>Protein:</strong> $protein</p>
                        <p><strong>Sugar:</strong> $sugar</p>
                        <p><strong>Fiber:</strong> $fiber</p>
                    </div>
                    HTML;
                }
            } else {
                echo "<p>No meal plans available for the selected date.</p>";
            }
            ?>
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
        function filterMealPlans() {
            const selectedDate = document.getElementById("selectedDate").value;
            if (selectedDate) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = window.location.href;
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selectedDate';
                input.value = selectedDate;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            } else {
                alert('Please select a date.');
            }
        }
    </script>
</body>
</html>