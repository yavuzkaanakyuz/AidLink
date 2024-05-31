<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'coordinator') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Operation Dashboard</title>
</head>
<body>
    <h1>Welcome, Operation Coordinator!</h1>
    <a href="view_requests.php">View Aid Requests</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
