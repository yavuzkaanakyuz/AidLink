<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'coordinator'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM donations";
$result = mysqli_query($conn, $query);
$donations = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Donations - Charity Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('donationhistory_background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        header {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 50px;
            height: auto;
            vertical-align: middle;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: rgba(0, 86, 179, 0.8);
        }
        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }
        nav a:hover {
            background-color: rgba(0, 61, 130, 0.8);
        }
        .content {
            padding: 20px;
            text-align: center;
            margin-top: 50px;
            background-color: rgba(0, 86, 179, 0.8);
            color: white;
        }
        .content h2 {
            color: white;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            max-width: 1000px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            color: #000;
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
        <h2>View All Donations</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name-Surname</th>
                    <th>Donor ID</th>
                    <th>Address</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Shipping Preference</th>
                    <th>Donation Date</th>
                </tr>
                <?php if (!empty($donations)): ?>
                    <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?php echo $donation['id']; ?></td>
                        <td><?php echo $donation['name_surname']; ?></td>
                        <td><?php echo $donation['donor_id']; ?></td>
                        <td><?php echo $donation['address']; ?></td>
                        <td><?php echo $donation['project']; ?></td>
                        <td><?php echo $donation['type']; ?></td>
                        <td><?php echo $donation['amount']; ?></td>
                        <td><?php echo $donation['shipping_preference']; ?></td>
                        <td><?php echo $donation['donation_date']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No donations found.</td>
                    </tr>
                <?php endif; ?>
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
