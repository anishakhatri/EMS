<?php 
session_start();
    if(!isset($_SESSION['username'])){
        header('login.php');
    }
    else if($_SESSION['usertype']=='admin'){
        header("location:login.php");
    }
    
    $host = "localhost";
$user = "root";
$password = "";
$db = "employeeproject";

$data = mysqli_connect($host, $user, $password, $db);

$name = $_SESSION['username'];

// Fetch the logged-in user's attendance
$sqlUser = "SELECT * FROM user WHERE username='$name'";
$userResult = mysqli_query($data, $sqlUser);
$userData = mysqli_fetch_assoc($userResult);

$employeeId = $userData['id'];

$sql = "SELECT a.id, a.employee_id, a.check_in_date, a.check_out_date, u.username, TIMEDIFF(a.check_out_date, a.check_in_date) as workedinterval FROM attendance a join user u on a.employee_id = u.id where u.id = '$employeeId'";
$result = mysqli_query($data, $sql);  


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
    <?php
    include 'employee_sidebar.php'; 
    ?>

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


    <div class="content">
        <center>
            <h1>Employee Attendance Data</h1>

            <br><br>
            
            <table>
                <tr>
                    <th class="table_th">Employee Name</th>
                    <th class="table_th">Check In</th>
                    <th class="table_th">Check Out</th>
                    <th class="table_th">Worked Interval</th>
                    
                </tr>

                <?php 
                while($info = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="table_td"><?php echo $info['username']; ?></td>
                    <td class="table_td"><?php echo $info['check_in_date']; ?></td>
                    <td class="table_td"><?php echo $info['check_out_date']; ?></td>
                    <td class="table_td"><?php echo $info['workedinterval']; ?></td>
                    
                </tr>
                <?php 
                }
                ?>
            </table>
        </center>
    </div>
</body>
</html>
