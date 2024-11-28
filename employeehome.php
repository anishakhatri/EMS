<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
} else if ($_SESSION['usertype'] == 'admin') {
    header("Location: login.php");
    exit();
}

$host="localhost";
$user="root";
$password= "";
$db= "employeeproject";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Database connection failed: " . mysqli_connect_error());
}

$name = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username='$name'";
$result = mysqli_query($data, $sql);
$info = mysqli_fetch_assoc($result);
$currentDateTime = date('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_in'])) {
        $employeeId = $info['id']; // Assuming 'employee_id' is in the user table
        $sqlCheckIn = "INSERT INTO attendance (employee_id, check_in_date, check_out_date) VALUES ('$employeeId', '$currentDateTime', NULL)";
        if (mysqli_query($data, $sqlCheckIn)) {
            echo "<script>alert('Check-In successful!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($data) . "');</script>";
        }
    } elseif (isset($_POST['check_out'])) {
        $employeeId = $info['id']; // Assuming 'employee_id' is in the user table
        $sqlCheckOut = "UPDATE attendance SET check_out_date='$currentDateTime' WHERE employee_id='$employeeId' AND check_out_date IS NULL";
        if (mysqli_query($data, $sqlCheckOut)) {
            echo "<script>alert('Check-Out successful!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($data) . "');</script>";
        }
    }
}
?>

<style>
/* Main Content */
.Maincontent {
    padding: 20px;
    background-color: #f1f1f1;
    overflow-y: auto;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Include Sidebar and Header -->
    <?php include 'employee_sidebar.php'; ?>

    <!-- Main Content -->
    <main class="Maincontent">
        <form method="POST">
            <div>
                <button type="submit" name="check_in" class="btn btn-secondary">Check In</button>
                <button type="submit" name="check_out" class="btn btn-danger">Check Out</button>
            </div>
        </form>
    </main>
</body>
</html>
