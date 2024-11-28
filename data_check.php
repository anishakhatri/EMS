<?php 

session_start();

$host="localhost";
$user="root";
$password="";
$db= "employeeproject";

$data=mysqli_connect($host,$user,$password,$db);

if($data==false){
    die("Connection error");
}

if(isset($_POST['apply'])){
    $data_name=$_POST['name'];
    $data_email=$_POST['email'];
    $data_phone=$_POST['phone'];
    $data_message=$_POST['message'];

    $sql="INSERT INTO new_employee(name,email,phone,message) Values ('$data_name', '$data_email', '$data_phone','$data_message')";

    $result=mysqli_query($data,$sql);

    if($result){
        $_SESSION['message']="your application sent successful";

        header("location:index.php");
    }
    else{
        "Apply Failed";
    }
}