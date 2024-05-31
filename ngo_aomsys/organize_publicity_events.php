<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'coordinator'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required POST variables are set
    if (isset($_POST['event_name']) && isset($_POST['date']) && isset($_POST['details'])) {
        include 'config.php';

        $event_name = $_POST['event_name'];
        $date = $_POST['date'];
        $details = $_POST['details'];

        // Insert the new event into the database
        $query = "INSERT INTO publicity_events (event_name, date, details) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $event_name, $date, $details);

        if ($stmt->execute()) {
            $message = "Event organized successfully.";
        } else {
            $message = "Error organizing event: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        $message = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organize Publicity Events</title>
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
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }
        .form-container input[type="text"], 
        .form-container input[type="date"], 
        .form-container textarea {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            display: <?php echo isset($message) ? 'block' : 'none'; ?>;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
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
        <h2>Organize Publicity Events</h2>
        <div class="form-container">
            <?php if (isset($message)): ?>
                <div class="notification"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST" action="organize_publicity_events.php">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                
                <label for="details">Details:</label>
                <textarea id="details" name="details"></textarea>
                
                <input type="submit" value="Organize Event">
            </form>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
            <?php else: ?>
                <a href="coordinator_dashboard.php" class="back-link">Back to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
