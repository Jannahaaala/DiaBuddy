<?php
include 'connection.php';

$sql = "SELECT type, date, time, ampm FROM notifications";
$result = $conn->query($sql);

$notifications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

echo json_encode($notifications);

$conn->close();
?>