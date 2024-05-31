<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .buttons-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
        }
        .buttons-container form {
            display: flex;
            flex-direction: column;
        }
        .buttons-container input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .buttons-container input[type="submit"]:hover {
            background-color: #0056b3;
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
        <h2>Admin Dashboard</h2>
        <div class="buttons-container">
            <form action="view_all_donations.php" method="GET">
                <input type="submit" value="View All Donations">
            </form>
            <form action="view_all_requests.php" method="GET">
                <input type="submit" value="View All Requests">
            </form>
            <form action="manage_users.php" method="GET">
                <input type="submit" value="Manage Users">
            </form>
            <form action="organize_publicity_events.php" method="GET">
                <input type="submit" value="Organize Publicity Events">
            </form>
            <form action="view_all_publicity_events.php" method="GET">
                <input type="submit" value="View All Publicity Events">
            </form>
            <form action="show_volunteers.php" method="GET">
                <input type="submit" value="Show Volunteers">
            </form>
            <form action="map.php" method="GET">
                <input type="submit" value="Show Map">
            </form>
        </div>
    </div>
</body>
</html>
