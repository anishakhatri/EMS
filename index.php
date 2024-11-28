<?php 
    error_reporting(0);
    session_start();
    session_destroy();

    if($_SESSION['message']){
        $message=$_SESSION['message'];
        echo"<script type='text/javascript'>
        alert('$message');
        </script>";
    }

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "employeeproject";


    $data = mysqli_connect($host, $user, $password, $db);

    $sql="SELECT * FROM department";
    $result = mysqli_query($data,$sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

    <nav>
        <label class="logo">EMS</label>
        <ul>
            
            <li><a href="login.php"class="btn btn-success">Login</a></li>
        </ul>
    </nav>

    <div class="section1">
        <label class="img_text">We Grow Together</label>
        <img class="main_img" src="employee.jpg" alt="">
    </div>
    
    <div class="container">
        <div class="row wel">
            <div class="col-md photo"-4>
                <img class="welcome_img" src="office.jpg" alt="">
            </div>
            <div class="col-md-8 text">
                <h1>Welcome to EMS</h1>
                <p>Our Employee Management System (EMS) is a powerful, all-in-one platform designed to revolutionize HR operations and drive workplace efficiency. It offers seamless management of critical functions such as employee records, attendance tracking, payroll processing, and performance evaluations, all within a secure and intuitive interface. Employees benefit from a self-service portal where they can effortlessly update their profiles, access pay slips, and submit leave requests, empowering them with greater control over their work-related information. Meanwhile, HR teams can efficiently manage roles, permissions, and compliance requirements, ensuring robust data security and streamlined workflows. By automating routine tasks and reducing human error, EMS saves valuable time, enhances data accuracy, and fosters transparent communication between employees and management. This creates a more organized, engaged, and highly productive workplace, enabling businesses to focus on what truly matters—growth and success.</p>
        </div>
    </div>

    <center>
        <h1>Our Employees </h1>
    </center>

    <div class="container">

        <div class="row thrcol">

            <div class="col-md-4" style="width: 33%;">

                <img class="employee"src="employee1.jpg" alt="">

                <p>David has been with us for 5 years and has consistently excelled in IT and has greatly contributed to. We appreciate his dedication and look forward to his continued success.</p>

            </div>

            <div class="col-md-4" style="width: 33%;">

                <img class="employee" src="employee1.jpg" alt="">

                <p>David has been with us for 5 years and has consistently excelled in IT and has greatly contributed to.
                    We appreciate his dedication and look forward to his continued success.</p>

            </div>
            <div class="col-md-4" style="width: 33%;">

                <img class="employee" src="employee1.jpg" alt="">

                <p>David has been with us for 5 years and has consistently excelled in IT and has greatly contributed to. We appreciate his dedication and look forward to his continued success.</p>

            </div>
        </div>
    </div>

    <center>
        <h1> Department </h1>
    </center>

    <div class="container">

        <div class="row thrcol">
            <?php
            while($info=$result->fetch_assoc()){
            
            ?>

            <div class="col-md-4" style="width: 33%;">

                <img class="department"src="<?php echo "{$info['image']}"?> " alt="">
                <h3><?php echo "{$info['name']}"?> </h3>
                
            </div>

            <?php
            }
            ?>
        </div>
    </div>

    <center>
        <h1 class="adm">New Employee Form </h1>
    </center>

    <div align="center" class="newemployee_form">
        <form action="data_check.php " method="POST">
            <div class="adm_int">
                <label class="label_text">Name</label>
                <input class="input_deg"type="text" name="name">
            </div>

            <div class="adm_int">
                <label class="label_text">Email</label>
                <input class="input_deg" type="text" name="email">
            </div>

            <div class="adm_int">
                <label class="label_text">Phone</label>
                <input class="input_deg" type="number" name="phone">
            </div>

            <div class="adm_int">
                <label class="label_text">Department Name</label>
                <textarea class="input_txt" name="message"></textarea>
            </div>

            <div class="adm_int">
            <button type="submit" name="apply">Apply</button>
            </div>
        </form>
    </div>

    <footer>
        <h3 class="footer_text">All @copyright reserved </h3>
    </footer>
</body>
</html>