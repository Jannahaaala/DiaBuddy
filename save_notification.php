<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $ampm = $_POST['ampm'];

    $sql = "INSERT INTO notifications (type, date, time, ampm) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $type, $date, $time, $ampm);

    if ($stmt->execute()) {
        echo "Notification saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>