<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'indigent') {
    header('Location: login.php');
    exit();
}

$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name_surname = $_POST['name_surname'];
    $monthly_income = $_POST['monthly_income'];
    $household_size = $_POST['household_size'];
    $num_children = $_POST['num_children'];
    $address = $_POST['address'];
    $education_status = json_encode($_POST['education_status']);
    $employment_status = $_POST['employment_status'];
    $monthly_expenditures = $_POST['monthly_expenditures'];
    $support_needed = $_POST['support_needed'];

    $query = "INSERT INTO aid_requests (indigent_id, name_surname, monthly_income, household_size, num_children, address, education_status, employment_status, monthly_expenditures, support_needed) VALUES ('$user_id', '$name_surname', '$monthly_income', '$household_size', '$num_children', '$address', '$education_status', '$employment_status', '$monthly_expenditures', '$support_needed')";
    if (mysqli_query($conn, $query)) {
        $notification = "Aid request submitted successfully.";
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
    <title>Aid Request - Charity Site</title>
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
        .form-container textarea,
        .form-container select {
            width: calc(100% - 22px); /* Fix text box bleed */
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
        <h2>Request Aid</h2>
        <div class="form-container">
            <form method="POST" action="request_aid.php">
                <label for="name_surname">Name-Surname</label>
                <input type="text" id="name_surname" name="name_surname" required><br>
                <label for="monthly_income">Monthly Income</label>
                <input type="text" id="monthly_income" name="monthly_income" required><br>
                <label for="household_size">Household Size</label>
                <input type="text" id="household_size" name="household_size" required><br>
                <label for="num_children">Number of Children</label>
                <input type="text" id="num_children" name="num_children" required><br>
                <label for="address">Address (x,y)</label>
                <input type="text" id="address" name="address" required><br>
                <label for="education_status">Education Status</label>
                <textarea id="education_status" name="education_status" required></textarea><br>
                <label for="employment_status">Employment Status</label>
                <input type="text" id="employment_status" name="employment_status" required><br>
                <label for="monthly_expenditures">Monthly Expenditures</label>
                <input type="text" id="monthly_expenditures" name="monthly_expenditures" required><br>
                <label for="support_needed">Support Needed</label>
                <select id="support_needed" name="support_needed">
                    <option value="furniture">Furniture</option>
                    <option value="food">Food</option>
                    <option value="cash">Cash</option>
                    <option value="clothing">Clothing</option>
                </select><br>
                <input type="submit" value="Request Aid">
            </form>
            <div class="additional-links">
                <p><a href="indigent_dashboard.php">Back to Dashboard</a></p>
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
