<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'coordinator' && $_SESSION['role'] != 'admin')) {
    header('Location: login.php');
    exit();
}

// Corrected query to use proper column names
$query = "SELECT address, 'donor' as type, name_surname as name FROM donations
          UNION ALL
          SELECT address, 'volunteer' as type, name_surname as name FROM volunteer_info
          UNION ALL
          SELECT address, 'indigent' as type, name_surname as name FROM aid_requests
          UNION ALL
          SELECT address, 'warehouse' as type, name as name FROM warehouses";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($conn));
}

$locations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Adding new warehouses for the 3rd and 4th quadrants
$locations[] = ['address' => '-15,-3', 'type' => 'warehouse', 'name' => 'Warehouse3'];
$locations[] = ['address' => '25,-15', 'type' => 'warehouse', 'name' => 'Warehouse4'];

$scale = 10; // Scaling factor
$mapWidth = 800;
$mapHeight = 600;
$centerX = $mapWidth / 2;
$centerY = $mapHeight / 2;

$icons = [
    'donor' => 'donor.png',
    'volunteer' => 'volunteer.png',
    'indigent' => 'indigent.png',
    'warehouse' => 'warehouse.png'
];
$iconSize = 40; // Increased icon size
$iconOffset = $iconSize / 2; // Offset to center the icons
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map - Charity Site</title>
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
        .map-container {
            position: relative;
            width: <?php echo $mapWidth; ?>px;
            height: <?php echo $mapHeight; ?>px;
            background-color: white;
            margin: 20px auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            background-image: linear-gradient(to right, #ccc 1px, transparent 1px), 
                              linear-gradient(to bottom, #ccc 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .map-container .point {
            position: absolute;
            width: <?php echo $iconSize; ?>px;
            height: <?php echo $iconSize; ?>px;
        }
        .map-container .username {
            position: absolute;
            width: <?php echo $iconSize; ?>px;
            text-align: center;
            font-size: 12px;
            color: black;
            transform: translateY(40px);
        }
        .axis {
            position: absolute;
            background-color: black;
        }
        .axis-x {
            width: 100%;
            height: 2px;
            top: 50%;
            left: 0;
        }
        .axis-y {
            width: 2px;
            height: 100%;
            top: 0;
            left: 50%;
        }
        #mapCanvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
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
        <h2>Map</h2>
        <div class="map-container" id="map">
            <div class="axis axis-x"></div>
            <div class="axis axis-y"></div>
            <?php foreach ($locations as $location): 
                $coordinates = explode(',', $location['address']);
                if (count($coordinates) == 2) {
                    $x = trim($coordinates[0]) * $scale;
                    $y = trim($coordinates[1]) * $scale;
                    if (is_numeric($x) && is_numeric($y)) {
                        $pointX = $centerX + $x - $iconOffset; // Adjust for icon width
                        $pointY = $centerY - $y - $iconOffset; // Adjust for icon height
            ?>
            <div style="left: <?php echo $pointX; ?>px; top: <?php echo $pointY; ?>px; position: absolute;">
                <img src="<?php echo $icons[$location['type']]; ?>" class="point <?php echo $location['type']; ?>">
                <div class="username"><?php echo htmlspecialchars($location['name']); ?></div>
            </div>
            <?php
                    } else {
                        echo "<!-- Invalid coordinates: {$location['address']} -->";
                    }
                } else {
                    echo "<!-- Invalid format: {$location['address']} -->";
                }
            endforeach;
            ?>
            <canvas id="mapCanvas" width="<?php echo $mapWidth; ?>" height="<?php echo $mapHeight; ?>" style="position: absolute; top: 0; left: 0;"></canvas>
        </div>
    </div>
    <script>
        const canvas = document.getElementById('mapCanvas');
        const ctx = canvas.getContext('2d');
        const centerX = <?php echo $centerX; ?>;
        const centerY = <?php echo $centerY; ?>;
        const scale = <?php echo $scale; ?>;

        function drawPath(path) {
            ctx.beginPath();
            ctx.moveTo(centerX + path[0].x * scale, centerY - path[0].y * scale);
            for (let i = 1; i < path.length; i++) {
                ctx.lineTo(centerX + path[i].x * scale, centerY - path[i].y * scale);
            }
            ctx.strokeStyle = 'red';
            ctx.lineWidth = 2;
            ctx.stroke();
        }

        const path1 = [
            {x: -25, y: 10},
            {x: -10, y: 20},
            {x: -25, y: 20},
            {x: -3, y: 7}
        ];

        const path2 = [
            {x: 10, y: 20},
            {x: 5, y: 10},
            {x: 5, y: 25},
            {x: 15, y: 10}
        ];

        const path3 = [
            {x: -15, y: -15},
            {x: -27, y: -3},
            {x: -15, y: -3},
            {x: -27, y: -15}
        ];

        const path4 = [
            {x: 10, y: -10},
            {x: 20, y: -5},
            {x: 25, y: -15},
            {x: 20, y: -20}
        ];

        drawPath(path1);
        drawPath(path2);
        drawPath(path3);
        drawPath(path4);
    </script>
</body>
</html>
