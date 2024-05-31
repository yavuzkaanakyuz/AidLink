<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'coordinator'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM publicity_events";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($conn));
}

$events = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Publicity Events</title>
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
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 1000px;
            overflow-x: auto; /* Add horizontal scrolling */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Fixed table layout */
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: normal; /* Allow text wrapping */
            word-wrap: break-word; /* Break long words */
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            color: #000; /* Set data text color to black for better readability */
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
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
        <h2>View All Publicity Events</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo $event['id']; ?></td>
                    <td><?php echo $event['event_name']; ?></td>
                    <td><?php echo $event['date']; ?></td>
                    <td><?php echo $event['details']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
            <?php else: ?>
                <a href="coordinator_dashboard.php" class="back-link">Back to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
