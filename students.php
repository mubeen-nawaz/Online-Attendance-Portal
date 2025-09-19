<?php
$conn = new mysqli("localhost", "root", "", "attendance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new student
if (isset($_POST['new_student'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO students (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        header("Location: students.php");
        exit();
    }
}

// Delete student
if (isset($_POST['delete_student'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: students.php");
        exit();
    }
}

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
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
            <a href="report.php" class="nav-link">📊 Reports</a>
            <a href="students.php" class="nav-link active">👥 Students</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <div class="topbar">
            <div class="breadcrumb">Dashboard / Students</div>
        </div>

        <div class="card">
            <h2>Student List</h2>

            <!-- Add Student Form -->
            <form method="POST" class="form" style="margin-bottom: 15px; display:flex; gap:10px; align-items:center;">
                <input type="text" name="name" placeholder="Enter student name" required>
                <button type="submit" name="new_student" class="btn primary">➕ Add Student</button>
            </form>

            <!-- Student Table -->
            <div class="table-wrap">
                <table class="data-table">
                    <tr><th>ID</th><th>Name</th><th>Action</th></tr>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_student" class="btn outline">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>
