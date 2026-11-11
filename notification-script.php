<?php
include "connection.php";

$user_id = 1;  
$sql = "SELECT blood_sugar_time, insulin_time, medication_time, meal_time FROM user_notifications WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $blood_sugar_time = $row['blood_sugar_time'];
    $insulin_time = $row['insulin_time'];
    $medication_time = $row['medication_time'];
    $meal_time = $row['meal_time'];
    $current_time = date("H:i");

    if ($current_time == $blood_sugar_time) {
        echo "Send Blood Sugar Reminder to User\n";
    }

    if ($current_time == $insulin_time) {
        echo "Send Insulin Reminder to User\n";
    }

    if ($current_time == $medication_time) {
        echo "Send Medication Reminder to User\n";
    }

    if ($current_time == $meal_time) {
        echo "Send Meal Time Reminder to User\n";
    }
}
$conn->close();
?>
