
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Site</title>
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
        .hero {
            background-image: url('charity_background_image.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        .hero h1 {
            font-size: 48px;
            margin: 0;
            color: #0056b3; /* More readable shade of blue */
        }
        .hero p {
            font-size: 24px;
            color: #0056b3; /* More readable shade of blue */
        }
        .content {
            padding: 20px;
            text-align: center;
            margin-top: 50px; /* Increase margin to lower the section */
            background-color: #0056b3; /* Match navigation bar color */
        }
        .content h2 {
            color: white; /* Change text color to white */
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            text-align: left;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons a {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .buttons a:hover {
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
        <a href="#">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>
    <div class="hero">
        <h1>“When one gives, two get happy.”</h1>
        <p>- Amit Kalantri, Wealth of Words</p>
    </div>
    <div class="content">
        <h2>Reason of Helping</h2>
        <div class="card">
            <h3>Collecting Fund</h3>
            <p>“No act of kindness, no matter how small, is ever wasted.”</p>
        </div>
        <div class="card">
            <h3>Food Donations</h3>
            <p>“This time give people a bread; instead of bread money :)”</p>
        </div>
        <div class="card">
            <h3>Friendly Volunteer</h3>
            <p>“If you think you are too small to be effective, try sleeping with a mosquito.”</p>
        </div>
    </div>
</body>
</html>
