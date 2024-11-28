

<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
} else if ($_SESSION['usertype'] == 'employee') {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "employeeproject";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM new_employee";
$result = mysqli_query($data, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($data));
}

// Fetch all rows into an array for sorting
$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

// Bubble Sort: Sort employees by name
for ($i = 0; $i < count($employees) - 1; $i++) {
    for ($j = 0; $j < count($employees) - $i - 1; $j++) {
        // Compare adjacent elements by 'name'
        if (strcasecmp($employees[$j]['name'], $employees[$j + 1]['name']) > 0) {
            // Swap elements if they are out of order
            $temp = $employees[$j];
            $employees[$j] = $employees[$j + 1];
            $employees[$j + 1] = $temp;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <style type="text/css">
        .table_th{
            padding: 20px;
            font-size: 20px;
        }

        .table_td{
            padding: 20px;
            background-color: skyblue;
        }
    </style> 
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Applied for New Employee</h1>
            <br><br> 
            <table style="border: red;">
                <tr>
                    <th class="table_th">Name</th>
                    <th class="table_th">Email</th>
                    <th class="table_th">Phone</th>
                    <th class="table_th">Department Name</th>
                </tr>

                <?php 
                foreach ($employees as $info)  {
                ?>
                <tr>
                    <td class="table_td"><?php echo htmlspecialchars($info['name']); ?></td>
                    <td class="table_td"><?php echo htmlspecialchars($info['email']); ?></td>
                    <td class="table_td"><?php echo htmlspecialchars($info['phone']); ?></td>
                    <td class="table_td"><?php echo htmlspecialchars($info['message']); ?></td>
                </tr>
                <?php 
                }
                ?>
            </table>
        </center>
    </div>
</body>
</html>
