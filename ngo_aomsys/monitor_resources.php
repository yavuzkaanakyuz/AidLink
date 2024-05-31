<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'coordinator') {
    header('Location: login.php');
    exit();
}

// Fetch total donations
$query = "SELECT SUM(amount) AS total_donations FROM donations";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_donations = $row['total_donations'];

// Fetch total volunteers
$query = "SELECT COUNT(*) AS total_volunteers FROM users WHERE role = 'volunteer'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_volunteers = $row['total_volunteers'];

// Fetch available aid items
$query = "SELECT COUNT(*) AS available_aid_items FROM aid_requests WHERE support_needed = 'furniture' OR support_needed = 'food' OR support_needed = 'clothing' OR support_needed = 'medical'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$available_aid_items = $row['available_aid_items'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Resources - Charity Site</title>
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
            background-color: #0056b3; /* Match navigation bar color */
            color: white;
        }
        .content h2 {
            color: white; /* Change text color to white */
        }
        .resource-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            text-align: left;
        }
        .resource-container p {
            color: #000;
        }
        .additional-links {
            text-align: center;
            margin-top: 10px;
        }
        .additional-links a {
            color: #007bff;
            text-decoration: none;
        }
        .additional-links a:hover {
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
        <h2>Monitor Resources</h2>
        <div class="resource-container">
            <p>Total Donations: $<?php echo number_format($total_donations, 2); ?></p>
            <p>Total Volunteers: <?php echo $total_volunteers; ?></p>
            <p>Available Aid Items: <?php echo $available_aid_items; ?></p>
            <div class="additional-links">
                <p><a href="coordinator_dashboard.php">Back to Dashboard</a></p>
            </div>
        </div>
    </div>
</body>
</html>
