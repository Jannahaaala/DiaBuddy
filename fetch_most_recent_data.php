<?php
include "connection.php";

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
echo json_encode($data);
$conn->close();
?>