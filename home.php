<?php
include "connection.php";

// Fetch image directory paths for the slideshow
$sql = "SELECT image_dir FROM images";
$result = $conn->query($sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $typeofdiabetes = mysqli_real_escape_string($conn, $_POST['type']);
    $currentmedication = mysqli_real_escape_string($conn, $_POST['medications']);
    $ExerciseFrequency = mysqli_real_escape_string($conn, $_POST['exercise']);
    $DietaryPreferences = mysqli_real_escape_string($conn, $_POST['diet']);
    $AdditionalNotes = mysqli_real_escape_string($conn, $_POST['notes']);

    if (!is_numeric($age) || $age < 5) {
        echo "Invalid age.";
        exit(); 
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit(); 
    }

    // Insert user data into the database
    $sql = "INSERT INTO mainpage (name, age, email, typeofdiabetes, currentmedication, ExerciseFrequency, DietaryPreferences, AdditionalNotes) 
            VALUES ('$name', '$age', '$email', '$typeofdiabetes', '$currentmedication', '$ExerciseFrequency', '$DietaryPreferences', '$AdditionalNotes')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.";
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
    <title>DiaBuddy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
        }
        header {
             background-color: #a181e0;
             color: white;
             padding: 20px;
             text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav a {
            color: white;
            text-decoration: none;
        }
        .nav-list {
            list-style-type: x;
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
        }
        .nav-box {
            background-color: white;
            color:#a181e0;
            border: solid black;
            border-radius: 8px;
            padding: 20px;
            width: 150px;
            transition: background-color 0.3;
        }
        .nav-box h3 {
            margin: 0;
            font-size: 16px;
            text-align: center;
        }
        .nav-box:hover {
            background-color: #a181e0;
        }
        .button {
            background-color: #a181e0;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .button:hover {
            background-color: #8c6db0;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #a181e0;
            outline: none;
        }
        .slideshow-container {
            position: relative;
            width: 100%;
            height: 500px;
        }
        .mySlides {
            display: none;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            user-select: none;
        }
        .next {
            right: 0;
        }
        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }
        .active, .dot:hover {
            background-color: #717171;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #a181e0;
            color: white;
        }
        h2 {
             text-align: center;
        }

    </style>
</head>
<body>
    <header>
        <h1>DiaBuddy: Your Diabetes Manager</h1>
        <nav>
            <ul>
                <li><a href="log_data.php" class="nav-link"><div class="nav-box"><h3>Log Data</h3></div></a></li>
                <li><a href="view_past_data.php" class="nav-link"><div class="nav-box"><h3>View Your Data</h3></div></a></li>
                <li><a href="meal-page.php" class="nav-link"><div class="nav-box"><h3>Meal Plan</h3></div></a></li>
                <li><a href="exercise-page.php" class="nav-link"><div class="nav-box"><h3>Exercise</h3></div></a></li>
                <li><a href="contact-us.php" class="nav-link"><div class="nav-box"><h3>Contact Us</h3></div></a></li>
            </ul>
        </nav>
    </header>

    <section id="slideshow">
        <div class="slideshow-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='mySlides' style='background-image:url(" . $row['image_dir'] . ")'></div>";
                }
            }
            ?>
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </section>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <section id="user-info">
            <h2>User Information</h2>
            <div class="form-container">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required placeholder="Enter your age">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="type">Type of Diabetes:</label>
                    <select id="type" name="type" required>
                        <option value="">Select...</option>
                        <option value="type1">Type 1</option>
                        <option value="type2">Type 2</option>
                        <option value="gestational">Gestational</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="medications">Current Medications:</label>
                    <textarea id="medications" name="medications" rows="4" placeholder="List your medications..."></textarea>
                </div>
                <div class="form-group">
                    <label for="exercise">Exercise Frequency:</label>
                    <select id="exercise" name="exercise" required>
                        <option value="">Select...</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="rarely">Rarely</option>
                        <option value="never">Never</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="diet">Dietary Preferences:</label>
                    <textarea id="diet" name="diet" rows="4" placeholder="Describe your dietary preferences..."></textarea>
                </div>
                <div class="form-group">
                    <label for="notes">Additional Notes:</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Any additional information..."></textarea>
                </div>
                <button type="submit" class="button">Submit</button>
            </div>
        </section>
    </form>

    <footer>
        <p>&copy; 2024 DiaBuddy</p>
    </footer>

    <script>
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

            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
</body>
</html>
