<style>
    /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    display: grid;
    grid-template-rows: auto 1fr;
    grid-template-columns: 250px 1fr;
    height: 100vh;
}

/* Header */
.header {
    grid-column: 1 / -1;
    /* background-color: #007bff; */
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    font-size: 18px;
}

.header a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

/* Sidebar */
.sidebar {
    background-color: #f8f9fa;
    padding: 20px;
    border-right: 1px solid #ddd;
}

.sidebar ul {
    list-style-type: none;
}

.sidebar ul li {
    margin-bottom: 15px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.sidebar ul li a:hover {
    background-color: #007bff;
    color: white;
}

</style>



<header class="header">
        <a href="employeehome.php">Employee Dashboard</a>
        <div class="logout">
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </header>
    <aside>
        <ul>
            <li>
                <a href="employee_profile.php">My Profile</a>
            </li>
            <!-- <li>
                <a href="employee_attendance.php">Attendance</a>
            </li> -->

            <li>
            <a href="employee_view_attendance.php">View Attendance</a>
            </li>
            

            
        </ul>
    </aside>