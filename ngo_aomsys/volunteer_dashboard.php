<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'volunteer') {
    header('Location: login.php');
    exit();
}

// Fetch volunteer info if exists
$volunteer_id = $_SESSION['user_id'];
$query = "SELECT * FROM volunteer_info WHERE volunteer_id = '$volunteer_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($conn));
}

$volunteer_info = mysqli_fetch_assoc($result);

// Fetch the current task for the volunteer
$task_query = "SELECT * FROM tasks WHERE assigned_volunteer_id = '$volunteer_id' ORDER BY id DESC LIMIT 1";
$task_result = mysqli_query($conn, $task_query);

if (!$task_result) {
    die("Error executing the task query: " . mysqli_error($conn));
}

$current_task = mysqli_fetch_assoc($task_result);

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_info'])) {
    $name_surname = $_POST['name_surname'];
    $job = $_POST['job'];
    $monthly_income = $_POST['monthly_income'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    
    if ($volunteer_info) {
        // Update existing info
        $update_query = "UPDATE volunteer_info SET name_surname = '$name_surname', job = '$job', monthly_income = '$monthly_income', city = '$city', address = '$address' WHERE volunteer_id = '$volunteer_id'";
        if (mysqli_query($conn, $update_query)) {
            $message = "Information updated successfully.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    } else {
        // Insert new info
        $insert_query = "INSERT INTO volunteer_info (volunteer_id, name_surname, job, monthly_income, city, address) VALUES ('$volunteer_id', '$name_surname', '$job', '$monthly_income', '$city', '$address')";
        if (mysqli_query($conn, $insert_query)) {
            $message = "Information saved successfully.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Handle transport availability
if (isset($_POST['transport_availability'])) {
    $transport = $_POST['transport'];
    $update_transport_query = "UPDATE volunteer_info SET transport_availability = '$transport' WHERE volunteer_id = '$volunteer_id'";
    mysqli_query($conn, $update_transport_query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        .logo {
            width: 50px;
            height: auto;
            vertical-align: middle;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #0056b3;
            position: relative;
        }
        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }
        nav a:hover {
            background-color: #003d82;
        }
        .content {
            padding: 20px;
            text-align: center;
            margin-top: 50px;
            background-color: #0056b3;
            color: white;
        }
        .content h2 {
            color: white;
        }
        .form-container, .buttons-container, .task-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
        }
        .form-container form, .buttons-container form, .task-container {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            margin-top: 10px;
            text-align: left;
            font-weight: bold;
            color: #333; /* Darker color for better readability */
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container select,
        .form-container input[type="submit"],
        .buttons-container input[type="submit"] {
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"], .buttons-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin: 0;
        }
        .form-container input[type="submit"]:hover, .buttons-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            display: <?php echo $message ? 'block' : 'none'; ?>;
        }
        .task-container {
            color: black;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo donation.png" alt="Charity Logo" class="logo">
        <h1>Charity Organization</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="content">
        <h2>Volunteer Dashboard</h2>
        <?php if ($message): ?>
            <div class="notification">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="form-container">
            <form method="POST" action="volunteer_dashboard.php">
                <label for="name_surname">Enter your name and surname:</label>
                <input type="text" id="name_surname" name="name_surname" value="<?php echo $volunteer_info['name_surname'] ?? ''; ?>" required>
                <label for="job">Enter your job:</label>
                <input type="text" id="job" name="job" value="<?php echo $volunteer_info['job'] ?? ''; ?>" required>
                <label for="monthly_income">Enter your average monthly income:</label>
                <input type="number" id="monthly_income" name="monthly_income" value="<?php echo $volunteer_info['monthly_income'] ?? ''; ?>" required>
                <label for="city">Enter the city where you want to work:</label>
                <input type="text" id="city" name="city" value="<?php echo $volunteer_info['city'] ?? ''; ?>" required>
                <label for="address">Enter your address (x,y):</label>
                <input type="text" id="address" name="address" value="<?php echo $volunteer_info['address'] ?? ''; ?>" required>
                <input type="submit" name="save_info" value="Save">
            </form>
        </div>
        <div class="buttons-container">
            <form method="POST" action="volunteer_dashboard.php">
                <label for="transport">Transport Availability:</label>
                <select id="transport" name="transport">
                    <option value="1" <?php echo isset($volunteer_info['transport_availability']) && $volunteer_info['transport_availability'] == 1 ? 'selected' : ''; ?>>I can provide my own transportation</option>
                    <option value="0" <?php echo isset($volunteer_info['transport_availability']) && $volunteer_info['transport_availability'] == 0 ? 'selected' : ''; ?>>I can't provide my own transportation</option>
                </select>
                <input type="submit" name="transport_availability" value="Save Transport Availability">
            </form>
            <form method="POST" action="volunteer_dashboard.php">
                <input type="submit" name="edit_profile" value="Edit Profile">
            </form>
        </div>
        <div class="task-container">
            <h3>Current Task</h3>
            <?php if ($current_task): ?>
                <p><strong>Task:</strong> <?php echo $current_task['task']; ?></p>
                <p><strong>Place:</strong> <?php echo $current_task['place']; ?></p>
                <p><strong>Time:</strong> <?php echo $current_task['time']; ?></p>
            <?php else: ?>
                <p>No current task assigned.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
