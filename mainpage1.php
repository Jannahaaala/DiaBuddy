<?php
include "connection.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT image_dir FROM images LIMIT 3";
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
            top: -3.5%;
            transform: translateY(-30%);
            transform: translateX(-20%);
            height: 130px;
            transition: transform 1s ease-in-out, width 1s ease-in-out, height 1s ease-in-out;
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
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        .button {
            background-color: #FF6F61;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .button:hover {
            background-color: #FF4C40;
            transform: scale(1.05);
        }
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        nav {
            background-color: #FF6F61;
            padding: 20px;
            text-align: center;
            animation: fadeIn 1s ease-in-out 0.5s;
            animation-fill-mode: forwards;
            opacity: 0;
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
            transform: translateY(-5px);
        }
        .slideshow-container {
            width: 85%;
            height: 430px;
            justify-content: center;
            margin: 50px auto;
            border-radius: 10px;
            align-items: center;
            z-index: 1;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            background-color: #E8F5F2;
            animation: fadeInSlide 1s ease-in-out;
        }
        @keyframes fadeInSlide {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .mySlides {
            display: none;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            animation: fadeInSlide 1s ease-in-out;
        }
        @keyframes fadeInSlide {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            transform: translateY(-50%);
        }
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
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
        .container2 {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-in-out 0.5s;
            animation-fill-mode: forwards;
            opacity: 0;
        }
        .notification-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out 0.7s;
            animation-fill-mode: forwards;
            opacity: 0;
        }
        h3 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus {
            border-color: #FF6F61;
            outline: none;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #FF4C40;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background-color: rgb(142, 37, 30);
            transform: scale(1.05);
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeIn 0.5s ease-in-out;
        }
        li button {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        li button:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: white;
            color: #FF6F61;
            position: relative;
            bottom: 0;
            width: 100%;
            animation: fadeIn 1s ease-in-out 1s;
            animation-fill-mode: forwards;
            opacity: 0;
            font-family: 'Lobster', cursive;
        }
        .alert {
            display: none;
            padding: 20px;
            background-color: #f44336;
            color: white;
            text-align: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            animation: slideInFromTop 0.5s ease-in-out;
        }
        .alert button {
            float: right;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        .chatbox {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 20px auto;
            text-align: center;
        }
        .chatbox input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .chatbox button {
            padding: 10px 20px;
            border: none;
            background-color: #FF4C40;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .chatbox button:hover {
            background-color: rgb(142, 37, 30);
        }
        .chat-log {
            margin-top: 20px;
            text-align: left;
        }
        .chat-log div {
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .user-msg {
            background-color: #E8F5F2;
            text-align: right;
        }
        .bot-msg {
            background-color: #FF6F61;
            color: white;
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
    <section id="slideshow" class="fade-in">
        <div class="slideshow-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='mySlides' style='background-image:url(".$row['image_dir'].")'></div>";
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
    <main>
        <div class="container2">
            <h3>To-Do List</h3>
            <input type="text" id="taskInput" placeholder="Enter a new task">
            <button id="addTaskButton">Add Task</button>
            <ul id="taskList"></ul>
        </div>
        <div class="notification-container">
            <h3>Set Notification</h3>
            <label for="notificationType">Type:</label>
            <select id="notificationType">
                <option value="meal">Meal</option>
                <option value="insulin">Insulin Dosage</option>
                <option value="bloodSugar">Blood Sugar Level Measurement</option>
            </select>
            <label for="notificationTime">Time:</label>
            <input type="time" id="notificationTime">
            <br>
            <label for="notificationAMPM">AM/PM:</label>
            <select id="notificationAMPM">
                <option value="AM">AM</option>
                <option value="PM">PM</option>
            </select>
            <br>
            <label for="notificationDate">Date:</label>
            <input type="date" id="notificationDate">
            <button id="setNotificationButton">Set Notification</button>
        </div>
        <br><br>
        <div class="alert" id="alert" style="display: none;">
    <span id="alertMessage"></span>
    <button id="closeAlertButton" style="float: right; background: none; border: none; color: white; font-size: 20px; cursor: pointer;">&times;</button>
</div>
<div class="chatbox">
            <h3>Diabetes Q&A</h3>
            <input type="text" id="userInput" placeholder="Ask your question...">
            <button id="askButton">Ask</button>
            <div class="chat-log" id="chatLog"></div>
        </div>
    </main>
    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            function addTask() {
                const taskInput = document.getElementById('taskInput');
                const task = taskInput.value.trim();

                if (task !== '') {
                    fetch('add_task.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `task=${encodeURIComponent(task)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        loadTasks();
                    })
                    .catch(error => console.error('Error:', error));

                    taskInput.value = '';
                }
            }
            function loadTasks() {
                fetch('get_tasks.php')
                    .then(response => response.json())
                    .then(tasks => {
                        const taskList = document.getElementById('taskList');
                        taskList.innerHTML = '';

                        tasks.forEach(task => {
                            const li = document.createElement('li');
                            li.textContent = task.task;

                            const removeButton = document.createElement('button');
                            removeButton.textContent = 'Remove';
                            removeButton.onclick = function() {
                                removeTask(task.id);
                            };

                            li.appendChild(removeButton);
                            taskList.appendChild(li);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
            function removeTask(taskId) {
                fetch('remove_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${taskId}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    loadTasks();
                })
                .catch(error => console.error('Error:', error));
            }

            document.getElementById('addTaskButton').onclick = addTask;
            document.getElementById('taskInput').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    addTask();
                }
            });

            loadTasks();

            document.getElementById('closeAlertButton').onclick = function() {
                document.getElementById('alert').style.display = 'none';
            };

            document.getElementById('setNotificationButton').onclick = function() {
                const type = document.getElementById('notificationType').value;
                const timeInput = document.getElementById('notificationTime').value;
                const ampm = document.getElementById('notificationAMPM').value;
                const date = document.getElementById('notificationDate').value;

                if (timeInput !== "" && date !== "") {
                    let [hour, minute] = timeInput.split(':').map(Number);
                    if (ampm === 'PM' && hour < 12) hour += 12;
                    if (ampm === 'AM' && hour === 12) hour = 0;

                    const notificationTime = new Date(`${date}T${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}:00`);
                    const now = new Date();
                    const timeToNotification = notificationTime.getTime() - now.getTime();

                    fetch('save_notification.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `type=${encodeURIComponent(type)}&date=${encodeURIComponent(date)}&time=${encodeURIComponent(timeInput)}&ampm=${encodeURIComponent(ampm)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        if (timeToNotification >= 0) {
                            setTimeout(() => {
                                document.getElementById('alertMessage').innerText = `Time for your ${type}!`;
                                document.getElementById('alert').style.display = 'block';
                                const alertSound = document.getElementById('alertSound');
                                alertSound.currentTime = 0; // Rewind to the start
                                alertSound.play().catch(error => {
                                    console.error('Playback error:', error);
                                });
                            }, timeToNotification);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                } else {
                    alert("Please set all notification fields.");
                }
            };

            function checkNotifications() {
                fetch('get_notifications.php')
                    .then(response => response.json())
                    .then(notifications => {
                        const now = new Date();
                        notifications.forEach(notification => {
                            const notificationTime = new Date(`${notification.date}T${notification.time}`);
                            if (notification.ampm === 'PM' && notificationTime.getHours() < 12) notificationTime.setHours(notificationTime.getHours() + 12);
                            if (notification.ampm === 'AM' && notificationTime.getHours() === 12) notificationTime.setHours(notificationTime.getHours() - 12);

                            const timeToNotification = notificationTime.getTime() - now.getTime();
                            if (timeToNotification >= 0) {
                                setTimeout(() => {
                                    document.getElementById('alertMessage').innerText = `Time for your ${notification.type}!`;
                                    document.getElementById('alert').style.display = 'block';
                                    const alertSound = document.getElementById('alertSound');
                                    alertSound.currentTime = 0;
                                    alertSound.play().catch(error => {
                                        console.error('Playback error:', error);
                                    });
                                }, timeToNotification);
                            }
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }

            checkNotifications();
        });
        const qaData = {
            "What is diabetes?": "Diabetes is a chronic medical condition characterized by elevated levels of blood glucose (or blood sugar), which occurs either because the body cannot produce enough insulin or because the cells do not respond properly to the insulin that is produced.",
            "What is the role of insulin in the body?": "Insulin, a hormone produced by the pancreas, is essential for regulating blood sugar levels and allowing glucose to enter cells, where it is used for energy.",
            "What are the main types of diabetes?": "The main types of diabetes are Type 1, Type 2, and gestational diabetes.",
            "What causes Type 1 diabetes?": "Type 1 diabetes is an autoimmune condition in which the immune system attacks and destroys the insulin-producing beta cells in the pancreas, leading to little or no insulin production.",
            "At what age does Type 1 diabetes typically develop?": "Type 1 diabetes typically develops in childhood or adolescence, though it can occur at any age.",
            "How is Type 1 diabetes managed?": "Type 1 diabetes requires lifelong insulin therapy to regulate blood sugar levels.",
            "What is Type 2 diabetes?": "Type 2 diabetes is a condition characterized by insulin resistance, where the body’s cells do not respond effectively to insulin, and over time, the pancreas may fail to produce enough insulin.",
            "What lifestyle factors are linked to Type 2 diabetes?": "Type 2 diabetes is closely linked to lifestyle factors such as obesity, physical inactivity, and poor diet.",
            "Is Type 2 diabetes more common in adults or children?": "Type 2 diabetes is more common in adults, but it is increasingly being diagnosed in younger populations due to rising obesity rates.",
            "What is gestational diabetes?": "Gestational diabetes occurs during pregnancy and usually resolves after childbirth, but it increases the risk of developing Type 2 diabetes later in life for both the mother and the child.",
            "What are the common symptoms of diabetes?": "Symptoms of diabetes can include frequent urination, excessive thirst, unexplained weight loss, extreme fatigue, blurred vision, slow-healing wounds, and recurrent infections.",
            "What are the potential complications of unmanaged diabetes?": "If left unmanaged, diabetes can lead to serious complications, including cardiovascular disease, kidney damage (nephropathy), nerve damage (neuropathy), eye damage (retinopathy), and an increased risk of infections and amputations.",
            "How is diabetes managed?": "Diabetes management typically involves a combination of lifestyle changes, such as adopting a healthy diet, engaging in regular physical activity, and maintaining a healthy weight, along with medications or insulin therapy as needed.",
            "Why is regular monitoring of blood glucose levels important?": "Regular monitoring of blood glucose levels is crucial for effective management of diabetes, as it helps individuals make informed decisions about diet, exercise, and medication.",
            "What technological advancements have improved diabetes management?": "Advances in medical technology, such as continuous glucose monitors and insulin pumps, have significantly improved the quality of life for many people with diabetes.",
            "Why are public health initiatives important for diabetes?": "Public health initiatives aimed at prevention, early detection, and education are essential in combating the global diabetes epidemic, which affects millions of people worldwide and poses a significant burden on healthcare systems."
        };

        document.getElementById('askButton').onclick = function() {
            const userInput = document.getElementById('userInput').value.trim();
            const chatLog = document.getElementById('chatLog');
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'user-msg';
            userMessageDiv.textContent = userInput;
            chatLog.appendChild(userMessageDiv);

            const botMessageDiv = document.createElement('div');
            botMessageDiv.className = 'bot-msg';

            if (qaData[userInput]) {
                botMessageDiv.textContent = qaData[userInput];
            } else {
                botMessageDiv.textContent = "Answer unavailable.";
            }
            chatLog.appendChild(botMessageDiv);
            document.getElementById('userInput').value = '';
            chatLog.scrollTop = chatLog.scrollHeight;
        };

    </script>
    <footer>
        <p>For more info about this program, please refer to the following:</p>
        <p>DiaBuddy is a program designed for people who have diabetes and struggle with keeping track of the many calculations involved in the process, such as insulin dosages, blood glucose levels, and in need of support. DiaBuddy doesn't just keep track of your data, but also provides a detailed meal and exercise plan based on your data.</p>
        <p>&copy; 2024 Diabetes Management Program</p>
    </footer>
</body>         
</html>