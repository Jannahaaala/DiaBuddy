<?php
$host = 'localhost';  
$db = 'database';  
$user = 'root';  
$pass = '';  

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$query = "SELECT * FROM recipes";
$stmt = $pdo->query($query);
$meals = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM recipes WHERE id = ?";
    $delete_stmt = $pdo->prepare($delete_query);
    $delete_stmt->execute([$delete_id]);
    header("Location: admin.php"); 
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $meal_name = $_POST['meal_name'];
    $suitable_for = $_POST['suitable_for'];
    $meal_type = $_POST['meal_type'];
    $recipe = $_POST['recipe'];
    $calories = $_POST['calories'];
    $carbohydrates = $_POST['carbohydrates'];
    $protein = $_POST['protein'];
    $sugar = $_POST['sugar'];
    $fiber = $_POST['fiber'];

    $update_query = "UPDATE recipes SET meal_name = ?, suitable_for = ?, meal_type = ?, recipe = ?, calories = ?, carbohydrates = ?, protein = ?, sugar = ?, fiber = ? WHERE id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$meal_name, $suitable_for, $meal_type, $recipe, $calories, $carbohydrates, $protein, $sugar, $fiber, $id]);

    header("Location: admin.php");
    exit();
}

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];
    $update_query = "SELECT * FROM recipes WHERE id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$update_id]);
    $meal = $update_stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Manage Meals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #FF6F61;
            font-family: 'Lobster', cursive;
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: bold;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #FF6F61;
            color: white;
        }
        .actions a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .update-form {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #FF6F61;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #FF6F61;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Meals</h1>
    </header>

    <table>
        <thead>
            <tr>
                <th>Meal Name</th>
                <th>Suitable For</th>
                <th>Meal Type</th>
                <th>Recipe</th>
                <th>Calories</th>
                <th>Carbohydrates</th>
                <th>Protein</th>
                <th>Sugar</th>
                <th>Fiber</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meals as $meal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($meal['meal_name']); ?></td>
                    <td><?php echo htmlspecialchars($meal['suitable_for']); ?></td>
                    <td><?php echo htmlspecialchars($meal['meal_type']); ?></td>
                    <td><?php echo htmlspecialchars($meal['recipe']); ?></td>
                    <td><?php echo htmlspecialchars($meal['calories']); ?></td>
                    <td><?php echo htmlspecialchars($meal['carbohydrates']); ?></td>
                    <td><?php echo htmlspecialchars($meal['protein']); ?></td>
                    <td><?php echo htmlspecialchars($meal['sugar']); ?></td>
                    <td><?php echo htmlspecialchars($meal['fiber']); ?></td>
                    <td class="actions">
                        <a href="?update_id=<?php echo $meal['id']; ?>">Update</a> | 
                        <a href="?delete_id=<?php echo $meal['id']; ?>" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($meal)): ?>
    <div class="update-form">
        <h2>Update Meal</h2>
        <form method="POST" action="admin.php">
            <input type="hidden" name="id" value="<?php echo $meal['id']; ?>">
            <label for="meal_name">Meal Name:</label>
            <input type="text" id="meal_name" name="meal_name" value="<?php echo htmlspecialchars($meal['meal_name']); ?>" required><br><br>
            <label for="suitable_for">Suitable For:</label>
            <input type="text" id="suitable_for" name="suitable_for" value="<?php echo htmlspecialchars($meal['suitable_for']); ?>" required><br><br>
            <label for="meal_type">Meal Type:</label>
            <input type="text" id="meal_type" name="meal_type" value="<?php echo htmlspecialchars($meal['meal_type']); ?>" required><br><br>
            <label for="recipe">Recipe:</label>
            <textarea id="recipe" name="recipe" required><?php echo htmlspecialchars($meal['recipe']); ?></textarea><br><br>
            <label for="calories">Calories:</label>
            <input type="number" id="calories" name="calories" value="<?php echo $meal['calories']; ?>" required><br><br>
            <label for="carbohydrates">Carbohydrates:</label>
            <input type="number" id="carbohydrates" name="carbohydrates" value="<?php echo $meal['carbohydrates']; ?>" required><br><br>
            <label for="protein">Protein:</label>
            <input type="number" id="protein" name="protein" value="<?php echo $meal['protein']; ?>" required><br><br>
            <label for="sugar">Sugar:</label>
            <input type="number" id="sugar" name="sugar" value="<?php echo $meal['sugar']; ?>" required><br><br>
            <label for="fiber">Fiber:</label>
            <input type="number" id="fiber" name="fiber" value="<?php echo $meal['fiber']; ?>" required><br><br>
            <input type="submit" name="update" value="Update Meal">
        </form>
    </div>
    <?php endif; ?>
</body>
</html>

