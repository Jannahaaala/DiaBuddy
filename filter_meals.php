<?php
include "connection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['date'])) {
    $date = $data['date'];


    $sql = "SELECT typeofdiabetes FROM viewdata WHERE Date = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Database query preparation failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();

    if ($user_data) {
        $diabetesType = $user_data['typeofdiabetes'];
        error_log("Diabetes Type: $diabetesType");

        $sql = "SELECT meal_name, image_url, suitable_for, meal_type, recipe, calories, carbohydrates, protein, sugar, fiber 
                FROM recipes WHERE suitable_for = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(['error' => 'Database query preparation failed: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("s", $diabetesType);
        $stmt->execute();
        $result = $stmt->get_result();
        $meals = [];

        while ($row = $result->fetch_assoc()) {
            $meals[] = $row;
        }

        $stmt->close();
        error_log("Meals: " . json_encode($meals)); 
        echo json_encode($meals);
    } else {
        echo json_encode(['error' => 'No data found for the selected date']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>