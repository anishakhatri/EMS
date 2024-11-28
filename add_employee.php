<?php 
session_start();
    if(!isset($_SESSION['username'])){
        header('login.php');
    }
    else if($_SESSION['usertype']== 'employee'){
        header("location:login.php");
    }

    $host="localhost";
    $user="root";
    $password= "";
    $db= "employeeproject";

    $data=mysqli_connect($host,$user,$password,$db);

    if(isset($_POST["add_employee"])){
        $username=$_POST['name'];
        $user_email= $_POST['email'];
        $user_phone= $_POST['phone'];
        $user_password= $_POST['password'];
        $usertype="employee";
        $gender=$_POST['gender'];
        $department_id = $_POST['department'];

        $check="SELECT * from user where username='$username'";

        $check_user=mysqli_query($data,$check);

        $row_count=mysqli_num_rows($check_user);

        if($row_count== 1){
            echo"<script type='text/javascript'>
            alert('Username already exist.Try another one');
            </script>";
            
        }
        else 
        {

       
        $sql="INSERT INTO user(username,email,phone,usertype,password,gender,department_id) VALUES ('$username','$user_email','$user_phone','$usertype','$user_password','$gender',$department_id)";
        $result=mysqli_query($data,$sql);

        if($result){
            echo"<script type='text/javascript'>
            alert('Employee Added Successfully');
            </script>";
        }
        else{
            echo "Upload Failed";
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
    <style>
        label
        {
            display:inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg{
            background-color: skyblue;
            width: 400px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
    </style>
</head>
<body>
    <?php
    include 'admin_sidebar.php'; 
    ?>

    <div class="content">
        <center>    
       <h1>Add Employee</h1>

       <div class="div_deg">
        <form action="#" method="POST">
            <div>
                <label >Username</label>
                <input type="text" name="name">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email">
            </div>
            <div>
                <label>Phone</label>
                <input type="number" name="phone">
            </div>
            <div>
                <label>Password</label>
                <input type="text" name="password">
            </div>
            <div>
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select Gender</option> <!-- Default option -->
                            <option value="male">Male</option>
                            <option value="female">Female</option>
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

                            
                                // Loop through the departments and create options for the dropdown
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            
                            ?>
                        </select>
            </div>
            <div>
                
                <input type="submit" class="btn btn-primary" name="add_employee" value="Add Employee">
            </div>
        </form>
       </div>
       </center>
    </div>
</body>
</html>