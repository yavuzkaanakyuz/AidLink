<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'coordinator' && $_SESSION['role'] != 'admin')) {
    header('Location: login.php');
    exit();
}

$query = "SELECT vi.volunteer_id, vi.name_surname, vi.job, vi.monthly_income, vi.city, vi.address, vi.transport_availability, u.username 
          FROM volunteer_info vi 
          JOIN users u ON vi.volunteer_id = u.id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($conn));
}

$volunteers = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_task'])) {
    $volunteer_id = $_POST['volunteer_id'];
    $task = $_POST['task'];
    $place = $_POST['place'];
    $time = $_POST['time'];

    $insert_task_query = "INSERT INTO tasks (assigned_volunteer_id, task, place, time) VALUES ('$volunteer_id', '$task', '$place', '$time')";
    if (mysqli_query($conn, $insert_task_query)) {
        $message = "Task assigned successfully.";
    } else {
        $message = "Error assigning task: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Volunteers</title>
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
        .form-container {
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            margin-top: 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }
        .form-container input[type="text"], 
        .form-container textarea, 
        .form-container input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            display: <?php echo isset($message) ? 'block' : 'none'; ?>;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
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
        <h2>Volunteers</h2>
        <?php if (isset($message)): ?>
            <div class="notification"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name-Surname</th>
                    <th>Job</th>
                    <th>Monthly Income</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Transport Availability</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($volunteers as $volunteer): ?>
                <tr>
                    <td><?php echo $volunteer['volunteer_id']; ?></td>
                    <td><?php echo $volunteer['username']; ?></td>
                    <td><?php echo $volunteer['name_surname']; ?></td>
                    <td><?php echo $volunteer['job']; ?></td>
                    <td><?php echo $volunteer['monthly_income']; ?></td>
                    <td><?php echo $volunteer['city']; ?></td>
                    <td><?php echo $volunteer['address']; ?></td>
                    <td><?php echo $volunteer['transport_availability'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <button onclick="showTaskForm(<?php echo $volunteer['volunteer_id']; ?>)">Give Task</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
            <?php else: ?>
                <a href="coordinator_dashboard.php" class="back-link">Back to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Task Assignment Form -->
    <div id="taskForm" class="form-container" style="display:none;">
        <form method="POST" action="show_volunteers.php">
            <input type="hidden" id="volunteer_id" name="volunteer_id">
            <label for="task">Task:</label>
            <textarea id="task" name="task" required></textarea>
            <label for="place">Place:</label>
            <input type="text" id="place" name="place" required>
            <label for="time">Time:</label>
            <input type="text" id="time" name="time" required>
            <input type="submit" name="assign_task" value="Assign Task">
        </form>
    </div>

    <script>
        function showTaskForm(volunteerId) {
            document.getElementById('volunteer_id').value = volunteerId;
            document.getElementById('taskForm').style.display = 'block';
        }
    </script>
</body>
</html>
