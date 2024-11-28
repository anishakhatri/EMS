


<?php 

error_reporting(0);
session_start();

// Check if the user is logged in and has the correct user type
if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();
} else if($_SESSION['usertype'] == 'employee'){
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "employeeproject";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die('Connection failed: ' . mysqli_connect_error());
}

// SQL query to fetch employee data
$sql = "SELECT u.id, u.username, u.phone, u.email, u.usertype, u.password, u.gender,d.name 
        FROM user u 
        LEFT JOIN department d ON u.department_id = d.id 
        WHERE u.usertype = 'employee'";

$result = mysqli_query($data, $sql);

// Check if query was successful
if (!$result) {
    die('Error in query: ' . mysqli_error($data));
}

// Fetch all rows into an array for sorting
$employees = [];
while ($row = $result->fetch_assoc()) {
    // Trim username to remove extra spaces and convert to lowercase
    $row['username'] = strtolower(trim($row['username']));
    $employees[] = $row;
}

// Bubble Sort: Sort employees by username
for ($i = 0; $i < count($employees) - 1; $i++) {
    for ($j = 0; $j < count($employees) - $i - 1; $j++) {
        // Handle null/empty usernames by treating them as empty strings    
        $usernameA = isset($employees[$j]['username']) ? $employees[$j]['username'] : '';
        $usernameB = isset($employees[$j + 1]['username']) ? $employees[$j + 1]['username'] : '';
        
        // Compare and swap if necessary
        if (strcasecmp($usernameA, $usernameB) > 0) {
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
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>

    <style type="text/css">
        .table_th {
            padding: 20px;
            font-size: 20px;
        }

        .table_td {
            padding: 20px;
            background-color: skyblue;
        }
    </style> 

    <div class="content">
        <center>
            <h1>Employee Data</h1>

            <?php  
            if ($_SESSION['message']) {
                echo $_SESSION['message'];
            }
            unset($_SESSION['message']);
            ?>

            <br><br>
            
            <table>
                <tr>
                    <th class="table_th">UserName</th>
                    <th class="table_th">Email</th>
                    <th class="table_th">Phone</th>
                    <th class="table_th">Password</th>
                    <th class="table_th">Gender</th>
                    <th class="table_th">Department</th>
                    <th class="table_th">Delete</th>
                    <th class="table_th">Update</th>
                </tr>

                <?php 
                foreach ($employees as $info) {
                ?>
                <tr>
                    <td class="table_td"><?php echo $info['username']; ?></td>
                    <td class="table_td"><?php echo $info['email']; ?></td>
                    <td class="table_td"><?php echo $info['phone']; ?></td>
                    <td class="table_td"><?php echo $info['password']; ?></td>
                    <td class="table_td"><?php echo ($info['gender'] === 'male') ? 'Male' : (($info['gender'] === 'female') ? 'Female' : ''); ?></td>
                    <td class="table_td"><?php echo $info['name']; ?></td>
                    <td class="table_td">
                        <?php echo "<a onClick=\"javascript:return confirm('Are you sure to delete this?')\" class='btn btn-danger' href='delete.php?employee_id={$info['id']}'>Delete</a>"; ?>
                    </td>
                    <td class="table_td">
                        <?php echo "<a class='btn btn-primary' href='update_employee.php?employee_id={$info['id']}'>Update</a>"; ?>
                    </td>
                </tr>
                <?php 
                }
                ?>
            </table>
        </center>
    </div>
</body>
</html>
