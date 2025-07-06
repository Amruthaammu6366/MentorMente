<?php
// Admin Manage Resources
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    // Optionally, delete the file from uploads folder (if exists)
    $f = $conn->query("SELECT file_path FROM resources WHERE id=$del_id");
    if ($f && $row = $f->fetch_assoc()) {
        $filepath = '../uploads/' . $row['file_path'];
        if (is_file($filepath)) @unlink($filepath);
    }
    $conn->query("DELETE FROM resources WHERE id=$del_id");
    header('Location: resources.php'); exit;
}
// Fetch all resources
$res = $conn->query("SELECT r.*, f.name as faculty_name FROM resources r JOIN faculty f ON r.faculty_id = f.id ORDER BY r.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link active" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="assignments.php">Assignments</a></li>
        <li class="nav-item"><a class="nav-link" href="studyplans.php">Study Plans</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">All Resources</h4>
    <div class="card p-4 mb-4 mt-5">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th><th>Title</th><th>File</th><th>Description</th><th>Faculty</th><th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php if($res && $res->num_rows): foreach($res as $r): ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo htmlspecialchars($r['title']); ?></td>
                    <td><?php if($r['file_path']): ?><a href="../uploads/<?php echo $r['file_path']; ?>" target="_blank">View</a><?php endif; ?></td>
                    <td><?php echo htmlspecialchars($r['description']); ?></td>
                    <td><?php echo htmlspecialchars($r['faculty_name']); ?></td>
                    <td><a href="?delete=<?php echo $r['id']; ?>" class="btn btn-sm btn-danger btn-del">Delete</a></td>
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
        if(!confirm('Delete this resource?')) e.preventDefault();
    });
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
