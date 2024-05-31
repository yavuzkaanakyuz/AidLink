<?php
include 'config.php';

$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    if (mysqli_query($conn, $query)) {
        $notification = "Registration successful.";
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
    <title>Register - Charity Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('login_background.jpg') no-repeat center center fixed;
            background-size: cover;
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
            background-color: rgba(0, 86, 179, 0.8);
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
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
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
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>
    <div class="content">
        <h2>Register</h2>
        <div class="form-container">
            <form method="POST" action="register.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="coordinator">Coordinator</option>
                    <option value="donor">Donor</option>
                    <option value="indigent">Indigent</option>
                    <option value="volunteer">Volunteer</option>
                </select>
                <input type="submit" value="Register">
            </form>
            <div class="additional-links">
                <p>Already have an account? <a href="login.php">Login here</a></p>
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
