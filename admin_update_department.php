


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

// Fetch department data for update
$department_id = $_GET['department_id'] ?? null;
if ($department_id) {
    $sql = "SELECT * FROM department WHERE id = '$department_id'";
    $result = mysqli_query($data, $sql);
    $department = mysqli_fetch_assoc($result);
}

// Handle form submission
if (isset($_POST['update_department'])) {
    $name = $_POST['name'];
    $new_image = $_FILES['image']['name'];
    $target_dir = "image/";
    
    if ($new_image) {
        $target_file = $target_dir . basename($new_image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $target_file = $department['image']; // Keep old image if new one is not uploaded
    }

    $update_sql = "UPDATE department SET name = '$name', image = '$target_file' WHERE id = '$department_id'";
    $update_result = mysqli_query($data, $update_sql);

    if ($update_result) {
        echo "<script>alert('Update Successful');</script>";
        echo "<script>window.location.href='admin_view_department.php';</script>";
        exit();
    } else {
        echo "<script>alert('Update Failed');</script>";
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
    <style>
        label {
            display: inline-block;
            width: 150px;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .form_deg {
            background-color: skyblue;
            width: 600px;
            padding-top: 70px;
            padding-bottom: 70px;
        }

        img {
            height: 100px;
            width: 100px;
        }
    </style>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>    
            <h1>Update Department</h1>
            <form class="form_deg" method="POST" enctype="multipart/form-data">
                <div>
                    <label>Department</label>
                    <input type="text" name="name" value="<?php echo $department['name']; ?>" required>
                </div>
                <div>
                    <label>Department old Image</label>
                    <img src="<?php echo $department['image']; ?>" alt="Old Image">
                </div>
                <div>
                    <label>Department new Image</label>
                    <input type="file" name="image">
                </div>
                <div>
                    <input type="submit" name="update_department" value="Update Department">
                </div>
            </form>
        </center>
    </div>
</body>
</html>
