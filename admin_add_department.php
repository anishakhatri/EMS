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

    if(isset($_POST['add_department'])){
        $t_name=$_POST['name'];
        $file=$_FILES['image']['name'];

        $dst="./image/".$file;

        $dst_db="image/".$file;

        move_uploaded_file($_FILES['image']['tmp_name'],$dst);

        $sql="INSERT INTO department(name,image) VALUES ('$t_name','$dst_db')";

        $result=mysqli_query($data,$sql);

        if($result){
            header('location:admin_add_department.php');
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        .div_deg{
            background-color: skyblue;
            padding-top: 70px;
            padding-bottom: 70px;
            width: 500px;
        }

    </style>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    include 'admin_sidebar.php'; 
    ?>

    <div class="content">
        
        <center>
       <h1>Add Department</h1><br><br> 
       <div class="div_deg">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div>
                <label>Department Name :</label>
                <input type="text" name="name">
            </div>
            <br>
            <div>
                <label>Image:</label>
                <input type="file" name="image">
            </div>
            <br>
            <div>
                
                <input type="submit" name="add_department" value="Add Department" class="btn btn-primary">
            </div>
        </form>
       </div>

       </center>
        
    </div>
</body>
</html>