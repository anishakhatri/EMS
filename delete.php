<?php 
session_start();

$host="localhost";
$user="root";
$password= "";
$db="employeeproject";

$data=mysqli_connect($host,$user,$password,$db);

if($_GET['employee_id']){
    $user_id=$_GET['employee_id'];
    $sql= "DELETE FROM user WHERE id='$user_id' ";
    $result=mysqli_query($data,$sql);

    if($result){
        $_SESSION['message']='Delete Employee is Successful';
        header("location:view_employee.php");
    }
}


?>