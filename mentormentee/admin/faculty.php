<?php
// Admin Manage Faculty
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    // Delete related records in other tables first
    $conn->query("DELETE FROM marks WHERE faculty_id=$del_id");
    $conn->query("DELETE FROM study_plan WHERE faculty_id=$del_id");
    $conn->query("DELETE FROM assignment WHERE faculty_id=$del_id");
    $conn->query("DELETE FROM resources WHERE faculty_id=$del_id");
    $conn->query("DELETE FROM attendance WHERE faculty_id=$del_id");
    // Then delete the faculty
    $conn->query("DELETE FROM faculty WHERE id=$del_id");
    header('Location: faculty.php'); exit;
}
// Fetch all faculty
$faculty = $conn->query("SELECT * FROM faculty ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Faculty - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link active" href="faculty.php">Faculty</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
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
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">All Faculty</h4>
    <div class="card p-4 mb-4 mt-5">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Phone</th><th>Address</th><th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php if($faculty && $faculty->num_rows): foreach($faculty as $f): ?>
                <tr>
                    <td><?php echo $f['id']; ?></td>
                    <td><?php echo htmlspecialchars($f['name']); ?></td>
                    <td><?php echo htmlspecialchars($f['username']); ?></td>
                    <td><?php echo htmlspecialchars($f['email']); ?></td>
                    <td><?php echo htmlspecialchars($f['phone']); ?></td>
                    <td><?php echo htmlspecialchars($f['address']); ?></td>
                    <td><a href="?delete=<?php echo $f['id']; ?>" class="btn btn-sm btn-danger btn-del">Delete</a></td>
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
        if(!confirm('Delete this faculty member?')) e.preventDefault();
    });
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
