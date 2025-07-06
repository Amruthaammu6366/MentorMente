<?php
// Parent View Child Marks
session_start();
if (!isset($_SESSION['parent_phone']) || !isset($_SESSION['parent_student_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$student_id = $_SESSION['parent_student_id'];
// Fetch marks for this student
$marks = $conn->query("SELECT m.*, f.name as faculty_name FROM marks m JOIN faculty f ON m.faculty_id = f.id WHERE m.student_id=$student_id ORDER BY m.date DESC, m.testname");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link active" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Marks</h4>
    <div class="card p-4 mb-4 mt-5">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Test Name</th><th>Date</th><th>Faculty</th><th>Semester</th><th>Marks</th><th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php if($marks && $marks->num_rows): foreach($marks as $m): ?>
                <tr>
                    <td><?php echo htmlspecialchars($m['testname']); ?></td>
                    <td><?php echo htmlspecialchars($m['date']); ?></td>
                    <td><?php echo htmlspecialchars($m['faculty_name']); ?></td>
                    <td><?php echo htmlspecialchars($m['semester']); ?></td>
                    <td><?php echo htmlspecialchars($m['marks']); ?></td>
                    <td><?php echo htmlspecialchars($m['total_marks']); ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="6" class="text-center">No marks found.</td></tr>
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
