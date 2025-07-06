<?php
// Student View Study Plan
session_start();
if (!isset($_SESSION['student_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$student_id = $_SESSION['student_id'];
// Get student's semester
$stu = $conn->query("SELECT semester FROM student WHERE id=$student_id");
$semester = $stu && $stu->num_rows ? $stu->fetch_assoc()['semester'] : 1;
// Fetch study plans for this semester (or all, as study plans are generally for all students)
$plans = $conn->query("SELECT s.*, f.name as faculty_name FROM study_plan s JOIN faculty f ON s.faculty_id = f.id ORDER BY s.date DESC, s.start_time DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Plan - MENTOR MENTEE</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard.php">MENTOR MENTEE</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li> 
        <li class="nav-item"><a class="nav-link active" href="studyplan.php">Study Plan</a></li>
        <li class="nav-item"><a class="nav-link" href="assignment.php">Assignments</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Study Plans</h4>
    <div class="card p-4 mb-4 mt-5">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Title</th><th>Date</th><th>Start</th><th>End</th><th>Description</th><th>Faculty</th>
                </tr>
            </thead>
            <tbody>
            <?php if($plans && $plans->num_rows): foreach($plans as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['title']); ?></td>
                    <td><?php echo htmlspecialchars($p['date']); ?></td>
                    <td><?php echo htmlspecialchars($p['start_time']); ?></td>
                    <td><?php echo htmlspecialchars($p['end_time']); ?></td>
                    <td><?php echo htmlspecialchars($p['description']); ?></td>
                    <td><?php echo htmlspecialchars($p['faculty_name']); ?></td>
                </tr>
            <?php endforeach; else: ?> 
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(function(){
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
