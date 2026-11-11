<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $hour = mysqli_real_escape_string($conn, $_POST['hour']);
    $minute = mysqli_real_escape_string($conn, $_POST['minute']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    $sql = "INSERT INTO notifications (type, notification_date, notification_hour, notification_minute)
            VALUES ('$type', '$date', '$hour', '$minute')";

    if ($conn->query($sql) === TRUE) {
        echo "Notification set successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
