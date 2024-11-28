<?php

error_reporting(0);
session_start();


$host = "localhost";
$user = "root";
$password = "";
$db = "employeeproject";


$data = mysqli_connect($host, $user, $password, $db);


if ($data === false) {
    die("Connection error");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $data->prepare($sql);

    $stmt->bind_param("ss", $name, $pass);

    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        if ($row["usertype"] === "employee") {
            
            $_SESSION['username']=$name;
            $_SESSION['usertype']="employee";
            header("Location: employeehome.php");
            exit();
        } elseif ($row["usertype"] === "admin") {

            $_SESSION['username']=$name;
            $_SESSION['usertype']="admin"; 
            header("Location: adminhome.php");
            exit();
        }
         
    }    else {
        
        session_start();
        $message= "Username or password do not match.";
        $_SESSION['loginMessage']=$message;
        header("location:login.php");
    }

   
    $stmt->close();
    $data->close();
}

?>


  