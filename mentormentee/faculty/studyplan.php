<?php
// Faculty Add/View/Delete Study Plan
session_start();
if (!isset($_SESSION['faculty_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$faculty_id = $_SESSION['faculty_id'];

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM study_plan WHERE id=$del_id AND faculty_id=$faculty_id");
    header('Location: studyplan.php'); exit;
}

// Handle Add Study Plan
$err = $succ = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $date = $conn->real_escape_string($_POST['date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $desc = $conn->real_escape_string($_POST['description']);
    $conn->query("INSERT INTO study_plan (faculty_id, title, date, start_time, end_time, description) VALUES ($faculty_id, '$title', '$date', '$start_time', '$end_time', '$desc')");
    $succ = 'Study plan added successfully!';
}

// Fetch study plans by this faculty
$plans = $conn->query("SELECT * FROM study_plan WHERE faculty_id=$faculty_id ORDER BY date DESC, start_time DESC");
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
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link active" href="studyplan.php">Study Plan</a></li>
        <li class="nav-item"><a class="nav-link" href="assignment.php">Assignment</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Manage Study Plans</h4>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card p-4 mb-4">
                <h5 class="mb-3">Add Study Plan</h5>
                <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
                <?php if($succ): ?><div class="alert alert-success"><?php echo $succ; ?></div><?php endif; ?>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="title" class="form-control" placeholder="Title" required>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="time" name="start_time" class="form-control" placeholder="Start Time" required>
                        </div>
                        <div class="col-md-6">
                            <input type="time" name="end_time" class="form-control" placeholder="End Time" required>
                        </div>
                        <div class="col-md-12">
                            <textarea name="description" class="form-control" placeholder="Description" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-5 mt-4">
                        <button type="reset" class="btn btn-danger w-100">Reset</button>
                        <button class="btn btn-primary w-100">Add Study Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card p-4 mb-4">
                <h5>All Study Plans</h5>
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Title</th><th>Date</th><th>Start</th><th>End</th><th>Description</th><th>Delete</th>
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
                            <td><a href="?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger btn-del">Delete</a></td>
                        </tr>
                    <?php endforeach; else: ?> 
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(function(){
    $('.btn-del').on('click', function(e){
        if(!confirm('Delete this study plan?')) e.preventDefault();
    });
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
