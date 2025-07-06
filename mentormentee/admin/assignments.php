<?php
// Admin Manage Assignments
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    // Optionally, delete the file from uploads folder (if exists)
    $f = $conn->query("SELECT file_path FROM assignment WHERE id=$del_id");
    if ($f && $row = $f->fetch_assoc()) {
        $filepath = '../uploads/' . $row['file_path'];
        if (is_file($filepath)) @unlink($filepath);
    }
    // Delete related assignment submissions first
    $conn->query("DELETE FROM assignment_submissions WHERE assignment_id=$del_id");
    // Then delete the assignment
    $conn->query("DELETE FROM assignment WHERE id=$del_id");
    header('Location: assignments.php'); exit;
}
// Fetch all assignments
$as = $conn->query("SELECT a.*, f.name as faculty_name FROM assignment a JOIN faculty f ON a.faculty_id = f.id ORDER BY a.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Assignments - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link active" href="assignments.php">Assignments</a></li>
        <li class="nav-item"><a class="nav-link" href="studyplans.php">Study Plans</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">All Assignments</h4>
    <div class="card p-4 mb-4 mt-5">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th><th>Subject</th><th>File</th><th>Description</th><th>Faculty</th><th>To Date</th><th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php if($as && $as->num_rows): foreach($as as $a): ?>
                <tr>
                    <td><?php echo $a['id']; ?></td>
                    <td><?php echo htmlspecialchars($a['subject']); ?></td>
                    <td><?php if($a['file_path']): ?><a href="../uploads/<?php echo $a['file_path']; ?>" target="_blank">View</a><?php endif; ?></td>
                    <td><?php echo htmlspecialchars($a['description']); ?></td>
                    <td><?php echo htmlspecialchars($a['faculty_name']); ?></td>
                    <td><?php echo htmlspecialchars($a['to_date']); ?></td>
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
        if(!confirm('Delete this assignment?')) e.preventDefault();
    });
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
