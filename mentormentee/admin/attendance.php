<?php
// Admin Manage Attendance
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM attendance WHERE id=$del_id");
    header('Location: attendance.php'); exit;
}
// Fetch all attendance records
$att = $conn->query("SELECT a.*, s.name as student_name, s.usn FROM attendance a JOIN student s ON a.student_id = s.id ORDER BY a.year DESC, a.month DESC, a.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
        <li class="nav-item"><a class="nav-link" href="faculty.php">Faculty</a></li>
        <li class="nav-item"><a class="nav-link active" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="assignments.php">Assignments</a></li>
        <li class="nav-item"><a class="nav-link" href="studyplans.php">Study Plans</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">All Attendance Records</h4>
    <div class="card p-4 mb-4 mt-5">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th><th>Student</th><th>USN</th><th>Subject</th><th>Month</th><th>Year</th><th>Total</th><th>Attended</th><th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php if($att && $att->num_rows): foreach($att as $a): ?>
                <tr>
                    <td><?php echo $a['id']; ?></td>
                    <td><?php echo htmlspecialchars($a['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($a['usn']); ?></td>
                    <td><?php echo htmlspecialchars($a['subject']); ?></td>
                    <td><?php echo htmlspecialchars($a['month']); ?></td>
                    <td><?php echo htmlspecialchars($a['year']); ?></td>
                    <td><?php echo htmlspecialchars($a['total_classes']); ?></td>
                    <td><?php echo htmlspecialchars($a['total_attended']); ?></td>
                    <td><a href="?delete=<?php echo $a['id']; ?>" class="btn btn-sm btn-danger btn-del">Delete</a></td>
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
    $('.btn-del').on('click', function(e){
        if(!confirm('Delete this attendance record?')) e.preventDefault();
    });
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
