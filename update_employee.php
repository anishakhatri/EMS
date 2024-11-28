<?php 
session_start();
    if(!isset($_SESSION['username'])){
        header('login.php');
    }
    else if($_SESSION['usertype']== 'employee'){
        header("location:login.php");
    }

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "employeeproject";

    $data = mysqli_connect($host, $user, $password, $db);
    $id=$_GET['employee_id'];

    $sql="SELECT * FROM user where id='$id'";
    $result = mysqli_query($data,$sql);
    $info=$result->fetch_assoc(); 


    if(isset($_POST['update'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $password=$_POST['password'];
        $gender=$_POST['gender'];
        $department_id = $_POST['department'];

        $query="UPDATE user SET username='$name',email='$email', phone='$phone', password='$password',gender='$gender',department_id='$department_id' WHERE id='$id' ";

        $result2=mysqli_query($data,$query);

        if($result2){
            header("location:view_employee.php");
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
        label{
            display: inline-block;
            width: 100px;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg{
            background-color: skyblue;
            width: 400px;
            padding-bottom: 70px;
            padding-top: 70px;
        }

    </style>

</head>
<body>
    <?php
    include 'admin_sidebar.php'; 
    ?>

    <div class="content">
        <center>
        
       <h1>Update Employee</h1>
        <div class="div_deg">
            <form action="#" method="POST">
                <div>
                    <label>UserName</label>
                    <input type="text" name="name" value="<?php echo" {$info['username']}"; ?>">
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" name="email" value="<?php echo" {$info['email']}"; ?>">
                </div>
                <div>
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo" {$info['phone']}"; ?>">
                </div>
                <div>
                    <label>Password</label>
                    <input type="text" name="password" value="<?php echo" {$info['password']}"; ?>">
                </div>
                <div>
                    <label>Department</label>
                    <select name="gender">
                        <option value="">Select Gender</option> <!-- Default option -->
                        <option value="male" <?php if ($info['gender'] == "male") echo "selected"; ?>>Male</option>
                        <option value="female" <?php if ($info['gender'] == "female") echo "selected"; ?>>Female</option>
                    </select>
                </div>
                <div>
                    <label>Department</label>
                    <select name="department">
                        <option value="">Select Department</option> <!-- Default option -->
                        <?php
                        // Fetch departments from the database
                        $sql = "SELECT id, name FROM department";
                        $result = mysqli_query($data, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            // Check if the current department matches the employee's department_id
                            $selected = ($row['id'] == $info['department_id']) ? "selected" : "";
                            echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    
                    <input class="btn btn-success" type="submit" name="update" value="Update">
                </div>
            </form>
        </div>
        </center>
    </div>
</body>
</html>