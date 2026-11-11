<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmSubmit'])) {
    $Date = mysqli_real_escape_string($conn, $_POST['datadate']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $typeofdiabetes = mysqli_real_escape_string($conn, $_POST['diabetesType']);
    $insulindosage = mysqli_real_escape_string($conn, $_POST['insulinDosage']);
    $bloodsugarlevel = mysqli_real_escape_string($conn, $_POST['bloodsugar']);
    $numberofmeals = mysqli_real_escape_string($conn, $_POST['mealsPerDay']);
    $exercise = mysqli_real_escape_string($conn, $_POST['exercise']);
    $preferences = mysqli_real_escape_string($conn, $_POST['allergies']);
    $healthgoals = mysqli_real_escape_string($conn, $_POST['goal']);
    $additionalcomments = mysqli_real_escape_string($conn, $_POST['comments']);

    $sql = "INSERT INTO viewdata (Date, age, weight, height, typeofdiabetes, insulindosage, bloodsugarlevel, numberofmeals, exercise, preferences, healthgoals, additionalcomments) 
            VALUES ('$Date', '$age', '$weight', '$height', '$typeofdiabetes', '$insulindosage', '$bloodsugarlevel', '$numberofmeals', '$exercise', '$preferences', '$healthgoals', '$additionalcomments')";

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

        header img.logo {
            position: absolute;
            left: 30px;
            top: 6%;
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

        input[type="text"], input[type="number"], input[type="time"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], button {
            margin-top: 20px;
            padding: 10px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #FFABAB; 
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: scale(1.02);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"],
        input[type="date"],
        button[type="submit"],
        button,
        select,
        textarea {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="submit"]:focus,
        input[type="date"]:focus,
        button[type="submit"]:focus,
        select:focus,
        button,
        textarea:focus {
            border-color: #FF6F61; 
            outline: none;
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

        .result-container {
            margin-top: 20px;
            padding: 20px;
            background: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .result-item {
            margin-bottom: 10px;
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
            <li class="nav-item"><a href="view_past_data.php" class="nav-link"><div class="nav-box"><h3>View Your Data</h></div></a></li>
            <li class="nav-item"><a href="meal-page.php" class="nav-link"><div class="nav-box"><h3>Meal Plan</h3></div></a></li>
            <li class="nav-item"><a href="exercise-page.php" class="nav-link"><div class="nav-box"><h3>Exercise</h3></div></a></li>
            <li class="nav-item"><a href="contact-us.php" class="nav-link"><div class="nav-box"><h3>Contact Us</h3></div></a></li>
            <li class="nav-item"><a href="login.php" class="nav-link"><div class="nav-box"><h3>Log Out</h3></div></a></li>
        </ul>
    </nav>
    </header>
    <main>
        <div class="form-container">
            <form id="dataForm" action="" method="POST" onsubmit="handleCalculate(event);">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="datadate" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <select id="age" name="age" required>
                        <?php for ($i = 1; $i <= 100; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="weight">Weight (kg):</label>
                    <select id="weight" name="weight" required>
                        <?php for ($i = 30; $i <= 200; $i += 0.5): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="height">Height (cm):</label>
                    <select id="height" name="height" required>
                        <?php for ($i = 100; $i <= 250; $i += 0.5): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="diabetesType">Type of Diabetes:</label>
                    <select id="diabetesType" name="diabetesType" required>
                        <option value="Type 1">Type 1</option>
                        <option value="Type 2">Type 2</option>
                        <option value="Gestational">Gestational</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="insulinDosage">Current Insulin Dosage (units):</label>
                    <input type="number" id="insulinDosage" name="insulinDosage" required min="0">
                </div>
                <div class="form-group">
                    <label for="bloodSugar">Current Blood Sugar Level (mg/dL):</label>
                    <input type="text" id="bloodsugar" name="bloodsugar" required placeholder="Enter comma-separated values">
                </div>
                <div class="form-group">
                    <label for="mealsPerDay">Number of Meals Per Day:</label>
                    <select id="mealsPerDay" name="mealsPerDay" required>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exercise">Daily Exercise (minutes):</label>
                    <select id="exercise" name="exercise" required>
                        <?php for ($i = 0; $i <= 300; $i += 10): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="allergies">Food Allergies or Preferences:</label>
                    <select id="allergies" name="allergies">
                        <option value="">None</option>
                        <option value="Nuts">Nuts</option>
                        <option value="Gluten">Gluten</option>
                        <option value="Dairy">Dairy</option>
                        <option value="Soy">Soy</option>
                        <option value="Eggs">Eggs</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="goal">Health Goals:</label>
                    <select id="goal" name="goal">
                        <option value="">Select a goal</option>
                        <option value="Weight loss">Weight loss</option>
                        <option value="Stabilizing blood sugar">Stabilizing blood sugar</option>
                        <option value="Increasing energy">Increasing energy</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="waist">Waist Circumference (cm):</label>
                    <input type="number" id="waist" name="waist" required min="0">
                </div>
                <div class="form-group">
                    <label for="comments">Additional Comments:</label>
                    <textarea id="comments" name="comments" rows="4" placeholder="Any other relevant information..."></textarea>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <label><input type="radio" name="gender" value="male" required> Male</label>
                    <label><input type="radio" name="gender" value="female" required> Female</label>
                </div>
                <input type="submit" value="Calculate">
            </form>
            <button id="confirmButton" class="hidden" onclick="handleConfirmSubmission()">Confirm and Submit</button>
        </div>
        <div id="resultContainer" class="result-container hidden">
            <div class="result-item" id="bmiResult"></div>
            <div class="result-item" id="bmrResult"></div>
            <div class="result-item" id="tdeeResult"></div>
            <div class="result-item" id="whtrResult"></div>
            <div class="result-item" id="bfpResult"></div>
            <div class="result-item" id="lbmResult"></div>
            <div class="result-item" id="avgBloodGlucoseResult"></div>
            <div class="result-item" id="stdDevBloodGlucoseResult"></div>
        </div>
    </main>
    <footer>
        <p>For more info about this program, please refer to the following:</p>
        <p>DiaBuddy is a program designed for people who have diabetes and struggle with keeping track of the many calculations involved in the process, such as insulin dosages, blood glucose levels, and in need of support. DiaBuddy doesn't just keep track of your data, but also provides a detailed meal and exercise plan based on your data.</p>
        <p>&copy; 2024 Diabetes Management Program</p>
    </footer>
    <script>
        document.querySelectorAll('.flip-container').forEach(container => {
            container.addEventListener('click', function() {
                const flipper = container.querySelector('.flipper');
                flipper.style.transform = 'rotateY(180deg)';
            });
        });

        document.getElementById('logo').addEventListener('click', function() {
            const logo = this;
            logo.classList.add('expand');
            setTimeout(() => {
                window.location.href = 'info.php';
            }, 3000);
        });

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

        function calculateBMI(weight, height) {
            height = height / 100;
            return (weight / (height * height)).toFixed(2);
        }

        function calculateBMR(weight, height, age, gender) {
            if (gender === 'male') {
                return (88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age)).toFixed(2);
            } else {
                return (447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age)).toFixed(2);
            }
        }

        function calculateTDEE(bmr, activityLevel) {
            const activityFactors = {
                'Sedentary': 1.2,
                'Lightly active': 1.375,
                'Moderately active': 1.55,
                'Very active': 1.725,
                'Super active': 1.9
            };
            return (bmr * activityFactors[activityLevel]).toFixed(2);
        }

        function calculateWHtR(waist, height) {
            return (waist / height).toFixed(2);
        }

        function calculateBFP(bmi, age, gender) {
            if (gender === 'male') {
                return ((1.20 * bmi) + (0.23 * age) - 16.2).toFixed(2);
            } else {
                return ((1.20 * bmi) + (0.23 * age) - 5.4).toFixed(2);
            }
        }

        function calculateLBM(weight, bodyFatPercentage) {
            return (weight - (weight * (bodyFatPercentage / 100))).toFixed(2);
        }

        function calculateAverage(values) {
            const sum = values.reduce((a, b) => a + b, 0);
            return (sum / values.length).toFixed(2);
        }

        function calculateStandardDeviation(values) {
            const avg = calculateAverage(values);
            const squareDiffs = values.map(value => Math.pow(value - avg, 2));
            const avgSquareDiff = calculateAverage(squareDiffs);
            return Math.sqrt(avgSquareDiff).toFixed(2);
        }

        function displayResults() {
            const weight = parseFloat(document.getElementById('weight').value);
            const height = parseFloat(document.getElementById('height').value);
            const age = parseInt(document.getElementById('age').value);
            const gender = document.querySelector('input[name="gender"]:checked').value;
            const activityLevel = document.getElementById('exercise').value;
            const waist = parseFloat(document.getElementById('waist').value);
            const bloodSugarValues = document.getElementById('bloodsugar').value.split(',').map(Number);

            const bmi = calculateBMI(weight, height);
            const bmr = calculateBMR(weight, height, age, gender);
            const tdee = calculateTDEE(bmr, activityLevel);
            const whtr = calculateWHtR(waist, height);
            const bfp = calculateBFP(bmi, age, gender);
            const lbm = calculateLBM(weight, bfp);
            const avgBloodGlucose = calculateAverage(bloodSugarValues);
            const stdDevBloodGlucose = calculateStandardDeviation(bloodSugarValues);

            document.getElementById('bmiResult').innerText = `BMI (Body Mass Index): ${bmi} - A measure of body fat based on height and weight.`;
            document.getElementById('bmrResult').innerText = `BMR (Basal Metabolic Rate): ${bmr} kcal/day - The number of calories your body needs to maintain basic physiological functions at rest.`;
            document.getElementById('tdeeResult').innerText = `TDEE (Total Daily Energy Expenditure): ${tdee} kcal/day - The total number of calories you need to maintain your current weight, accounting for physical activity.`;
            document.getElementById('whtrResult').innerText = `WHtR (Waist-to-Height Ratio): ${whtr} - A measure of the distribution of body fat, calculated as waist circumference divided by height.`;
            document.getElementById('bfpResult').innerText = `BFP (Body Fat Percentage): ${bfp}% - The percentage of your body that is made up of fat.`;
            document.getElementById('lbmResult').innerText = `LBM (Lean Body Mass): ${lbm} kg - The weight of everything in your body except for fat (muscles, bones, water, etc.).`;
            document.getElementById('avgBloodGlucoseResult').innerText = `Average Blood Glucose: ${avgBloodGlucose} mg/dL`;
            document.getElementById('stdDevBloodGlucoseResult').innerText = `Standard Deviation of Blood Glucose: ${stdDevBloodGlucose}`;

            document.getElementById('resultContainer').classList.remove('hidden');
            document.getElementById('confirmButton').classList.remove('hidden');
        }

        function handleCalculate(event) {
            event.preventDefault();

            displayResults();
        }

        function handleConfirmSubmission() {
            const confirmField = document.createElement('input');
            confirmField.type = 'hidden';
            confirmField.name = 'confirmSubmit';
            confirmField.value = 'true';
            document.getElementById('dataForm').appendChild(confirmField);
            document.getElementById('dataForm').submit();
        }
    </script>
</body>
</html>