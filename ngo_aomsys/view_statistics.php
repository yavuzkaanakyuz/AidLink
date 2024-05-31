<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM statistics";
$result = mysqli_query($conn, $query);
$statistics = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Statistics - Charity Site</title>
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
            max-width: 800px;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
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
        <h2>View Statistics</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Year</th>
                    <th>Total Donations</th>
                    <th>Total Aid Distributed</th>
                    <th>New Volunteers</th>
                    <th>Volunteers Left</th>
                    <th>Operations Handled</th>
                    <th>Items in Stock</th>
                    <th>Publicity Events</th>
                </tr>
                <?php foreach ($statistics as $stat): ?>
                <tr>
                    <td><?php echo $stat['year']; ?></td>
                    <td><?php echo $stat['total_donations']; ?></td>
                    <td><?php echo $stat['total_aid_distributed']; ?></td>
                    <td><?php echo $stat['new_volunteers']; ?></td>
                    <td><?php echo $stat['volunteers_left']; ?></td>
                    <td><?php echo $stat['operations_handled']; ?></td>
                    <td><?php echo $stat['items_in_stock']; ?></td>
                    <td><?php echo $stat['publicity_events']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="additional-links">
                <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
            </div>
        </div>
    </div>
</body>
</html>
