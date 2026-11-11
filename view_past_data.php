<?php
include "connection.php";

$user_data = []; 
$most_recent_data = [];
$blood_sugar_data = [];

if (isset($_GET['datadate']) && !empty($_GET['datadate'])) {
    $date = $_GET['datadate']; 

    $sql = "SELECT age, weight, height, typeofdiabetes, insulindosage, bloodsugarlevel, 
                   numberofmeals, exercise, preferences, healthgoals, additionalcomments 
            FROM viewdata 
            WHERE Date = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $date); 
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();  
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
} 

$sql = "SELECT age, weight, height, typeofdiabetes, insulindosage, bloodsugarlevel, 
               numberofmeals, exercise, preferences, healthgoals, additionalcomments 
        FROM viewdata 
        ORDER BY Date DESC 
        LIMIT 1";

if ($result = $conn->query($sql)) {
    $most_recent_data = $result->fetch_assoc();
} else {
    echo "Error fetching the most recent data: " . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Past Data</title>
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
        label {
            display: block;
            margin-top: 10px;
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
        header img.logo {
            position: absolute;
            left: 30px;
            top: 1%;
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
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            align-items: center;
            justify-content: center;
            border: solid #FF6F61;
        }
        .datadate {
            justify-content: center;
            align-items: center;
        }
        .chart-container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 2px solid #FF6F61; 
            border-radius: 8px;
            background-color: white; 
        }
        canvas {
            font-weight: bold; 
        }
        button {
            display: block; 
            margin: 20px auto; 
            padding: 10px 20px; 
            background-color: #FF6F61; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: background-color 0.3s ease; 
        }
        button:hover {
            background-color: #FF4F41; 
        }
        button:focus {
            outline: none; 
            box-shadow: 0 0 5px #FF6F61;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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

    <script>
        async function fetchInsulinData() {
            const response = await fetch('fetch_insulin_data.php');
            const data = await response.json();
            return data;
        }

        async function fetchBloodSugarData() {
            const response = await fetch('fetch_bloodsugar_data.php');
            const data = await response.json();
            return data;
        }

        async function fetchMostRecentData() {
            const response = await fetch('fetch_most_recent_data.php');
            const data = await response.json();
            return data;
        }

        async function generateGraph() {
            const insulinData = await fetchInsulinData();
            const bloodSugarData = await fetchBloodSugarData();

            const insulinLabels = insulinData.map(entry => entry.date);
            const insulinValues = insulinData.map(entry => entry.insulindosage);

            const bloodSugarLabels = bloodSugarData.map(entry => entry.date);
            const bloodSugarValues = bloodSugarData.map(entry => entry.bloodsugarlevel);

            const insulinCtx = document.getElementById('insulinChart').getContext('2d');
            new Chart(insulinCtx, {
                type: 'line',
                data: {
                    labels: insulinLabels,
                    datasets: [{
                        label: 'Insulin Dosage Over Time',
                        data: insulinValues,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: { title: { display: true, text: 'Date' } },
                        y: { title: { display: true, text: 'Insulin Dosage (units)' } }
                    }
                }
            });

            const bloodSugarCtx = document.getElementById('bloodSugarChart').getContext('2d');
            new Chart(bloodSugarCtx, {
                type: 'line',
                data: {
                    labels: bloodSugarLabels,
                    datasets: [{
                        label: 'Blood Sugar Levels Over Time',
                        data: bloodSugarValues,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: { title: { display: true, text: 'Date' } },
                        y: { title: { display: true, text: 'Blood Sugar Level (mg/dL)' } }
                    }
                }
            });
        }

        function generateReport() {
            const userData = {
                age: "<?php echo htmlspecialchars($user_data['age']); ?>",
                weight: "<?php echo htmlspecialchars($user_data['weight']); ?>",
                height: "<?php echo htmlspecialchars($user_data['height']); ?>",
                diabetesType: "<?php echo htmlspecialchars($user_data['typeofdiabetes']); ?>",
                insulinDosage: "<?php echo htmlspecialchars($user_data['insulindosage']); ?>",
                bloodSugar: "<?php echo htmlspecialchars($user_data['bloodsugarlevel']); ?>",
                mealsPerDay: "<?php echo htmlspecialchars($user_data['numberofmeals']); ?>",
                exercise: "<?php echo htmlspecialchars($user_data['exercise']); ?>",
                allergies: "<?php echo htmlspecialchars($user_data['preferences']); ?>",
                healthGoals: "<?php echo htmlspecialchars($user_data['healthgoals']); ?>",
                comments: "<?php echo htmlspecialchars($user_data['additionalcomments']); ?>"
            };

            const reportContent = `
                Date: <?php echo htmlspecialchars($date); ?>\n
                Age: ${userData.age}\n
                Weight: ${userData.weight} kg\n
                Height: ${userData.height} cm\n
                Type of Diabetes: ${userData.diabetesType}\n
                Current Insulin Dosage: ${userData.insulinDosage} units\n
                Current Blood Sugar Level: ${userData.bloodSugar} mg/dL\n
                Number of Meals per Day: ${userData.mealsPerDay}\n
                Daily Exercise: ${userData.exercise} minutes\n
                Food Allergies: ${userData.allergies || 'None'}\n
                Health Goals: ${userData.healthGoals || 'None'}\n
                Additional Comments: ${userData.comments || 'None'}
            `;

            alert(reportContent);
        }
    </script>
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
    <section id="user-info" class="fade-in">
        <br><br><br>
        <form action="" method="GET" class="form-container">
            <div class="form-group">
                <label for="datadate">Select a date to view your data:</label>
                <input type="date" id="datadate" name="datadate" required>
            </div>
            <button type="submit">View Data</button>
        </form>
        <br>

        <?php if (!empty($user_data)): ?>
            <div class="form-container">
                <strong>Age:</strong> <?php echo htmlspecialchars($user_data['age']); ?><br><br>
                <strong>Weight:</strong> <?php echo htmlspecialchars($user_data['weight']); ?><br><br>
                <strong>Height:</strong> <?php echo htmlspecialchars($user_data['height']); ?><br><br>
                <strong>Type of Diabetes:</strong> <?php echo htmlspecialchars($user_data['typeofdiabetes']); ?><br><br>
                <strong>Insulin Dosage:</strong> <?php echo htmlspecialchars($user_data['insulindosage']); ?><br><br>
                <strong>Blood Sugar Level:</strong> <?php echo htmlspecialchars($user_data['bloodsugarlevel']); ?><br><br>
                <strong>Meals per Day:</strong> <?php echo htmlspecialchars($user_data['numberofmeals']); ?><br><br>
                <strong>Exercise:</strong> <?php echo htmlspecialchars($user_data['exercise']); ?><br><br>
                <strong>Allergies:</strong> <?php echo htmlspecialchars($user_data['preferences']); ?><br><br>
                <strong>Health Goal:</strong> <?php echo htmlspecialchars($user_data['healthgoals']); ?><br><br>
                <strong>Additional Comments:</strong> <?php echo htmlspecialchars($user_data['additionalcomments']); ?><br><br>
                <button onclick="generateReport()">Generate Report</button>
            </div>
        <?php elseif (isset($_GET['datadate'])): ?>
            <div class="form-container">
                No data found for this date!
            </div>
        <?php endif; ?>

        <?php if (!empty($most_recent_data)): ?>
            <div class="form-container">
                <h2>MOST RECENT DATA</h2>
                <strong>Age:</strong> <?php echo htmlspecialchars($most_recent_data['age']); ?><br><br>
                <strong>Weight:</strong> <?php echo htmlspecialchars($most_recent_data['weight']); ?><br><br>
                <strong>Height:</strong> <?php echo htmlspecialchars($most_recent_data['height']); ?><br><br>
                <strong>Type of Diabetes:</strong> <?php echo htmlspecialchars($most_recent_data['typeofdiabetes']); ?><br><br>
                <strong>Insulin Dosage:</strong> <?php echo htmlspecialchars($most_recent_data['insulindosage']); ?><br><br>
                <strong>Blood Sugar Level:</strong> <?php echo htmlspecialchars($most_recent_data['bloodsugarlevel']); ?><br><br>
                <strong>Meals per Day:</strong> <?php echo htmlspecialchars($most_recent_data['numberofmeals']); ?><br><br>
                <strong>Exercise:</strong> <?php echo htmlspecialchars($most_recent_data['exercise']); ?><br><br>
                <strong>Allergies:</strong> <?php echo htmlspecialchars($most_recent_data['preferences']); ?><br><br>
                <strong>Health Goal:</strong> <?php echo htmlspecialchars($most_recent_data['healthgoals']); ?><br><br>
                <strong>Additional Comments:</strong> <?php echo htmlspecialchars($most_recent_data['additionalcomments']); ?><br><br>
            </div>
        <?php endif; ?>=
        <button onclick="generateGraph()">Track</button>
    </section>
    <div class="chart-container">
        <canvas id="insulinChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="bloodSugarChart"></canvas>
    </div>
    <br><br>
    <footer>
        <p>For more info about this program, please refer to the following:</p>
        <p>DiaBuddy is a program designed for people who have diabetes and struggle with keeping track of the many calculations involved in the process, such as insulin dosages, blood glucose levels, and in need of support. DiaBuddy doesn't just keep track of your data, but also provides a detailed meal and exercise plan based on your data.</p>
        <p>&copy; 2024 Diabetes Management Program</p>
    </footer>
</body>
</html>