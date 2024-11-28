<!-- <?php 
session_start();
    if(!isset($_SESSION['username'])){
        header('login.php');
    }
    else if($_SESSION['usertype']=='admin'){
        header("location:login.php");
    }   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    
    <?php
    include 'employee_sidebar.php'
     ?>

    
</body>
</html>


 -->



 <?php
// Get the current year
$currentYear = date('Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yearly Calendar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .yearly-calendar {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .month {
            border: 1px solid #ccc;
            padding: 10px;
            width: 300px;
            text-align: center;
        }
        .month h2 {
            margin: 0;
            font-size: 1.5em;
            background-color: skyblue;
            color: white;
            padding: 5px 0;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 10px;
        }
        .day, .header {
            padding: 5px;
            text-align: center;
        }
        .header {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .empty {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Calendar for <?php echo $currentYear; ?></h1>
    <div class="yearly-calendar">
        <?php
        // Loop through all 12 months
        for ($month = 1; $month <= 12; $month++):
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $currentYear);
            $firstDayOfMonth = date('w', strtotime("$currentYear-$month-01")); // Day of the week for the 1st
        ?>
            <div class="month">
                <h2><?php echo date('F', mktime(0, 0, 0, $month, 1, $currentYear)); ?></h2>
                <div class="calendar">
                    <!-- Calendar Headers -->
                    <div class="header">Sun</div>
                    <div class="header">Mon</div>
                    <div class="header">Tue</div>
                    <div class="header">Wed</div>
                    <div class="header">Thu</div>
                    <div class="header">Fri</div>
                    <div class="header">Sat</div>

                    <!-- Empty cells for days before the 1st -->
                    <?php for ($i = 0; $i < $firstDayOfMonth; $i++): ?>
                        <div class="day empty"></div>
                    <?php endfor; ?>

                    <!-- Days of the month -->
                    <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                        <div class="day"><?php echo $day; ?></div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</body>
</html>
