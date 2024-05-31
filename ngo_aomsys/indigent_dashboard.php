<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indigent - Charity Site</title>
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
            background-color: rgba(0, 86, 179, 0.8);
            position: relative;
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
        .form-container input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"],
        .form-container button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .form-container input[type="submit"]:hover,
        .form-container button:hover {
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
        <h2>Indigent Dashboard</h2>
        <div class="form-container">
            <p>Welcome to the Indigent dashboard!</p>
            <button onclick="location.href='request_aid.php'">Request Aid</button>
        </div>
    </div>
</body>
</html>
