<?php
include "connection.php";

$sql = "SELECT Date, insulindosage FROM viewdata ORDER BY Date ASC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date' => $row['Date'],
            'insulindosage' => $row['insulindosage']
        ];
    }
}

echo json_encode($data);
$conn->close();
?>