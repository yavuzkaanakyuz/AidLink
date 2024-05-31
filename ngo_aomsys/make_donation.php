<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'donor') {
    header('Location: login.php');
    exit();
}

$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_id = $_SESSION['user_id'];
    $name_surname = mysqli_real_escape_string($conn, $_POST['name_surname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $project = mysqli_real_escape_string($conn, $_POST['project']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $shipping_preference = mysqli_real_escape_string($conn, $_POST['shipping_preference']);

    $query = "INSERT INTO donations (donor_id, name_surname, address, project, type, amount, shipping_preference) VALUES ('$donor_id', '$name_surname', '$address', '$project', '$type', '$amount', '$shipping_preference')";
    if (mysqli_query($conn, $query)) {
        $notification = "Donation successfully made.";
    } else {
        $notification = "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Donation - Charity Site</title>
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
            text-align: left;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
            color: #000;
        }
        .form-container input[type="text"],
        .form-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
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
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            display: <?php echo $notification ? 'block' : 'none'; ?>;
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
        <h2>Make a Donation</h2>
        <div class="form-container">
            <form method="POST" action="make_donation.php">
                <label for="name_surname">Name-Surname</label>
                <input type="text" id="name_surname" name="name_surname" required><br>
                <label for="address">Address (x,y)</label>
                <input type="text" id="address" name="address" required><br>
                <label for="project">Project</label>
                <input type="text" id="project" name="project" required><br>
                <label for="type">Type</label>
                <select id="type" name="type">
                    <option value="cash">Cash</option>
                    <option value="food">Food</option>
                    <option value="clothing">Clothing</option>
                    <option value="furniture">Furniture</option>
                </select><br>
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" required><br>
                <label for="shipping_preference">Shipping Preference</label>
                <select id="shipping_preference" name="shipping_preference">
                    <option value="self">Self</option>
                    <option value="collect">Collect</option>
                </select><br>
                <input type="submit" value="Donate">
            </form>
            <div class="additional-links">
                <p><a href="donor_dashboard.php">Back to Dashboard</a></p>
            </div>
            <?php if ($notification): ?>
                <div class="notification">
                    <?php echo $notification; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
