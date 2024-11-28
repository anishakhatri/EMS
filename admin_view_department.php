

<?php 
session_start();
error_reporting(0);

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

if (isset($_GET['department_id'])) {
    $t_id = $_GET['department_id'];

    $sql2 = "DELETE FROM department WHERE id='$t_id'";
    $result2 = mysqli_query($data, $sql2);

    if ($result2) {
        echo "<script>alert('Delete Successful');</script>";
        echo "<script>window.location.href = 'admin_view_department.php';</script>";
        exit();
    } else {
        echo "<script>alert('Delete Failed');</script>";
    }
}

$sql = "SELECT * FROM department";
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
    <style>
        .table_th {
            padding: 20px;
            font-size: 20px;
        }
        .table_td {
            padding: 20px;
            background-color: skyblue;
        }
    </style>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>View All Departments</h1>
            <table border="1px">
                <tr>
                    <th class="table_th">Department Name</th>
                    <th class="table_th">Image</th>
                    <th class="table_th">Delete</th>
                    <th class="table_th">Update</th>
                </tr>

                <?php while ($info = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="table_td"><?php echo $info['name']; ?></td>
                        <td class="table_td">
                            <img height="100px" width="100px" src="<?php echo $info['image']; ?>" />
                        </td>
                        <td class="table_td">
                            <a class='btn btn-danger' href='admin_view_department.php?department_id=<?php echo $info['id']; ?>'>Delete</a>
                        </td>

                        <td class="table_td">
                            <?php 
                            echo"

                            <a href='admin_update_department.php?department_id={$info['id']}' class='btn btn-primary'>Update</a>";

                            ?>

                        </td>
                    </tr>
                <?php } ?>
            </table>
        </center>
    </div>
</body>
</html>
