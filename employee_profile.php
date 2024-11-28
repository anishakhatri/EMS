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
    $name=$_SESSION['username'];
    $sql="SELECT * FROM user WHERE username='$name' ";
    $result=mysqli_query($data,$sql);
    $info=mysqli_fetch_assoc($result);

    if(isset($_POST['update_profile'])){
        $s_email=$_POST['email'];
        $s_phone=$_POST['phone'];
        $s_password=$_POST['password'];
        $department_id = $_POST['department'];

        $sql2="UPDATE user SET email='$s_email',phone='$s_phone',password='$s_password',department_id = '$department_id' WHERE username='$name' ";

        $result2=mysqli_query($data,$sql2);

        if($result2){
            header('location:employee_profile.php');
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
    
    <?php
    include 'employee_sidebar.php'
     ?>

     <style>
        label{
            display: inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg{
            background-color: skyblue;
            width: 500px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
     </style>

     <div class="content">
        <center>
            <h1>Update Profile</h1>
            <br><br>
        <form action="#" method="POST">

            <div class="div_deg">

            

            
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo"{$info['email']}" ?>">
            </div>
            <div>
                <label>Phone</label>
                <input type="number" name="phone" value="<?php echo"{$info['phone']}" ?>">
            </div>
            <div>
                <label>Password</label>
                <input type="text" name="password" value="<?php echo"{$info['password']}" ?>">
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
                <input type="submit" class="btn btn-primary" name="update_profile" value="Update">
            </div>

            </div>
        </form>
        </center>

     </div>

    
</body>
</html>