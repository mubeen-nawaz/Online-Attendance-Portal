<?php
$conn = new mysqli("localhost", "root", "", "attendance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$attendanceData = null;
if (isset($_POST['date'])) {
    $date = $_POST['date'];
    $sql = "SELECT s.name, a.status 
            FROM attendance a
            JOIN students s ON a.student_id = s.id
            WHERE a.date = '$date'";
    $attendanceData = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Reports</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="bg-overlay"></div>

<div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">📘 Attendance Portal</div>
        <div class="role-pill">Teacher Panel</div>
        <nav class="nav">
            <a href="index.php" class="nav-link">🏠 Home</a>
            <a href="report.php" class="nav-link active">📊 Reports</a>
            <a href="students.php" class="nav-link">👥 Students</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <div class="topbar">
            <div class="breadcrumb">Dashboard / Reports</div>
        </div>

        <div class="card">
            <h2>Attendance Report</h2>
            <form method="POST" action="">
                <label>Select Date: </label>
                <input type="date" name="date" required>
                <button type="submit" class="btn primary">View</button>
            </form>
            <br>
            <?php if ($attendanceData !== null) { ?>
                <h3>Report for <?php echo $_POST['date']; ?></h3>
                <div class="table-wrap">
                    <table class="data-table">
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                        </tr>
                        <?php 
                        if ($attendanceData->num_rows > 0) {
                            while ($row = $attendanceData->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td class="<?php echo ($row['status']=='Present')?'present':'absent'; ?>">
                                        <?php echo $row['status']; ?>
                                    </td>
                                </tr>
                            <?php } 
                        } else {
                            echo "<tr><td colspan='2'>No records found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </main>
</div>
</body>
</html>
