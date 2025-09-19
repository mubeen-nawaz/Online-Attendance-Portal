<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "attendance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students
$result = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Dashboard</title>
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
            <a href="index.php" class="nav-link active">🏠 Home</a>
            <a href="report.php" class="nav-link">📊 Reports</a>
            <a href="students.php" class="nav-link">👥 Students</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <div class="topbar">
            <div class="breadcrumb">Dashboard / Attendance</div>
        </div>

        <div class="card">
            <h2>Mark Attendance</h2>
            <form method="POST" action="save_attendance.php" class="form">
                <div class="table-wrap">
                    <table class="data-table">
                        <tr>
                            <th>Student Name</th>
                            <th>Present</th>
                            <th>Absent</th>
                        </tr>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><input type="radio" name="status[<?php echo $row['id']; ?>]" value="Present" required></td>
                            <td><input type="radio" name="status[<?php echo $row['id']; ?>]" value="Absent"></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <br>
                <button type="submit" class="btn primary">Save Attendance</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
