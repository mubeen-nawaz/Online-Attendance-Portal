<?php
$conn = new mysqli("localhost", "root", "", "attendance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = date("Y-m-d");

foreach ($_POST['status'] as $student_id => $status) {
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $student_id, $date, $status);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Saved</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="bg-overlay"></div>
<div class="page center-page">
    <div class="card login-card">
        <h2>✅ Attendance saved successfully!</h2>
        <a href="index.php" class="btn primary">← Back to Attendance</a>
        <a href="report.php" class="btn outline">📊 View Reports</a>
    </div>
</div>
</body>
</html>
