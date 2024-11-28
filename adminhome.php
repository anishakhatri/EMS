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

if (!$data) {
    die("Database connection failed: " . mysqli_connect_error());
}

$name = $_SESSION['username'];

// Fetch the logged-in user's attendance
$sqlUser = "SELECT * FROM user WHERE username='$name'";
$userResult = mysqli_query($data, $sqlUser);
$userData = mysqli_fetch_assoc($userResult);

$employeeId = $userData['id'];

$sqlAttendance = "SELECT * FROM attendance WHERE employee_id = '$employeeId' ORDER BY check_in_date DESC LIMIT 1";
$attendanceResult = mysqli_query($data, $sqlAttendance);
$attendance = mysqli_fetch_assoc($attendanceResult);

// Calculate today's present users count
$currentDate = date('Y-m-d');
$sqlPresentCount = "SELECT COUNT(DISTINCT employee_id) AS present_count 
                    FROM attendance 
                    WHERE DATE(check_in_date) = '$currentDate'";
$presentResult = mysqli_query($data, $sqlPresentCount);
$presentCountData = mysqli_fetch_assoc($presentResult);
$presentCount = $presentCountData['present_count'];


$sqlemployeeCount = "SELECT COUNT(DISTINCT id) AS total_employee 
                    FROM user where usertype = 'employee'";
$employeeResult = mysqli_query($data, $sqlemployeeCount);
$employeeCountData = mysqli_fetch_assoc($employeeResult);
$employeeCount = $employeeCountData['total_employee'];


$sqldepartmentCount = "SELECT COUNT(DISTINCT id) AS total_departments 
                    FROM department";
$departmentResult = mysqli_query($data, $sqldepartmentCount);
$departmentCountData = mysqli_fetch_assoc($departmentResult);
$departmentCount = $departmentCountData['total_departments'];


$sqldepartmentNames = "SELECT DISTINCT name FROM department";
$departmentNameResult = mysqli_query($data, $sqldepartmentNames);

$departmentNames = [];

// Fetch each department name and add it to the array
while ($row = mysqli_fetch_assoc($departmentNameResult)) {
    $departmentNames[] = $row['name'];
}

$sqldepartmentEmployee = "SELECT d.name, count(u.id) as count FROM department d join user u on d.id = u.department_id group by d.name";
$departmentEmployeeResult = mysqli_query($data, $sqldepartmentEmployee);

$departmentEmployee = [];

// Fetch each department name and add it to the array
while ($row = mysqli_fetch_assoc($departmentEmployeeResult)) {
    $departmentEmployee[] = $row['count'];
}





$gendersql = "SELECT gender, COUNT(*) AS count FROM user where gender is not null GROUP BY gender";
$genderresult = mysqli_query($data, $gendersql);

$counts = [];

while ($row = mysqli_fetch_assoc($genderresult)) {
    $counts[] = (int)$row['count'];  // Add count as an integer to the array
}


?>

<!-- <style>
    .c-dashboardInfo {
  margin-bottom: 15px;
}
.c-dashboardInfo .wrap {
  background: #ffffff;
  box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
  border-radius: 7px;
  text-align: center;
  position: relative;
  overflow: hidden;
  padding: 40px 25px 20px;
  height: 100%;
}
.c-dashboardInfo__title,
.c-dashboardInfo__subInfo {
  color: #6c6c6c;
  font-size: 1.18em;
}
.c-dashboardInfo span {
  display: block;
}
.c-dashboardInfo__count {
  font-weight: 600;
  font-size: 2.5em;
  line-height: 64px;
  color: #323c43;
}
.c-dashboardInfo .wrap:after {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 10px;
  content: "";
}

.c-dashboardInfo:nth-child(1) .wrap:after {
  background: linear-gradient(82.59deg, #00c48c 0%, #00a173 100%);
}
.c-dashboardInfo:nth-child(2) .wrap:after {
  background: linear-gradient(81.67deg, #0084f4 0%, #1a4da2 100%);
}
.c-dashboardInfo:nth-child(3) .wrap:after {
  background: linear-gradient(69.83deg, #0084f4 0%, #00c48c 100%);
}
.c-dashboardInfo:nth-child(4) .wrap:after {
  background: linear-gradient(81.67deg, #ff647c 0%, #1f5dc5 100%);
}
.c-dashboardInfo__title svg {
  color: #d7d7d7;
  margin-left: 5px;
}
.MuiSvgIcon-root-19 {
  fill: currentColor;
  width: 1em;
  height: 1em;
  display: inline-block;
  font-size: 24px;
  transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
  user-select: none;
  flex-shrink: 0;
}



.card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 400px;
        padding: 20px;
        text-align: center;
    }
    .card h3 {
        margin: 0;
        font-size: 1.5em;
        color: #333333;
    }
    .card p {
        margin: 10px 0;
        font-size: 1em;
        color: #666666;
    }
    .card .highlight {
        font-weight: bold;
        color: #007bff;
    }
    .card .status {
        margin-top: 15px;
        padding: 10px;
        border-radius: 5px;
        font-size: 1em;
        color: #ffffff;
        background-color: #00c48c;
    }
    .card .status.check-out {
        background-color: #ff647c;
    }

</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    include 'admin_sidebar.php'; 
    ?>

    <div class="content">
    <div class="card">
        <h3>Today's Present Employee</h3>
        <div class="present-count">
            Today's Present Users: <?php echo $presentCount; ?>
        </div>
    </div>
    <div class="card">
        <h3>Total Employees </h3>
        <div class="present-count">
            Employees: <?php echo $employeeCount; ?>
        </div>
    </div>

    <div class="card">
        <h3>Total Departments </h3>
        <div class="present-count">
            Departments: <?php echo $departmentCount; ?>
        </div>
    </div>

    <h2 style="text-align: center;">Gender Distribution</h2>
    <canvas id="genderPieChart" style="width: 100% !important; height: 40% !important;"></canvas>
    
        
    </div>

    <script>
        // Get PHP data into JavaScript
        const genders = <?php echo json_encode($genders); ?>;
        const counts = <?php echo json_encode($counts); ?>;

        // Create the chart
        const ctx = document.getElementById('genderPieChart').getContext('2d');
        const genderPieChart = new Chart(ctx, {
            type: 'pie', // Pie chart type
            data: {
                labels: genders, // Labels from PHP
                datasets: [{
                    data: counts, // Data from PHP
                    backgroundColor: ['#4CAF50', '#FFC107'], // Colors for the pie sections
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const label = genders[tooltipItem.dataIndex];
                                const value = counts[tooltipItem.dataIndex];
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html> -->


<style>
    .c-dashboardInfo {
  margin-bottom: 15px;
}
.c-dashboardInfo .wrap {
  background: #ffffff;
  box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
  border-radius: 7px;
  text-align: center;
  position: relative;
  overflow: hidden;
  padding: 40px 25px 20px;
  height: 100%;
}
.c-dashboardInfo__title,
.c-dashboardInfo__subInfo {
  color: #6c6c6c;
  font-size: 1.18em;
}
.c-dashboardInfo span {
  display: block;
}
.c-dashboardInfo__count {
  font-weight: 600;
  font-size: 2.5em;
  line-height: 64px;
  color: #323c43;
}
.c-dashboardInfo .wrap:after {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 10px;
  content: "";
}

.c-dashboardInfo:nth-child(1) .wrap:after {
  background: linear-gradient(82.59deg, #00c48c 0%, #00a173 100%);
}
.c-dashboardInfo:nth-child(2) .wrap:after {
  background: linear-gradient(81.67deg, #0084f4 0%, #1a4da2 100%);
}
.c-dashboardInfo:nth-child(3) .wrap:after {
  background: linear-gradient(69.83deg, #0084f4 0%, #00c48c 100%);
}
.c-dashboardInfo:nth-child(4) .wrap:after {
  background: linear-gradient(81.67deg, #ff647c 0%, #1f5dc5 100%);
}
.c-dashboardInfo__title svg {
  color: #d7d7d7;
  margin-left: 5px;
}
.MuiSvgIcon-root-19 {
  fill: currentColor;
  width: 1em;
  height: 1em;
  display: inline-block;
  font-size: 24px;
  transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
  user-select: none;
  flex-shrink: 0;
}


</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include 'admin_sidebar.php'; 
    ?>

    <div class="content">
    <div class="container-fluid">

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Today's Present Employee</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $presentCount; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Employees</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $employeeCount; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Departments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $departmentCount; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Department Wise Employee Distribution</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Gender Distribution</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Male
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Female
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
    </div>

    <script>
        const GenderValue = <?php echo json_encode($counts); ?>;
        const DepartmentName = <?php echo json_encode($departmentNames); ?>;
        const DepartmentEmployee = <?php echo json_encode($departmentEmployee); ?>;
    </script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    
</body>
</html>








<!-- Custom fonts for this template-->






                <!-- Bootstrap core JavaScript-->
   