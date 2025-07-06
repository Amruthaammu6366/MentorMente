<?php
// Faculty Dashboard
session_start();
if (!isset($_SESSION['faculty_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$faculty_id = $_SESSION['faculty_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - MENTOR MENTEE</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../index.php">MENTOR MENTEE</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link" href="studyplan.php">Study Plan</a></li>
        <li class="nav-item"><a class="nav-link" href="assignment.php">Assignment</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center text-primary">Welcome, Faculty!</h2>
    <div class="row g-4 justify-content-center my-4">
        <div class="col-md-3">
            <a href="marks.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-clipboard-data-fill display-4 text-danger"></i></div>
                    <h5 class="fw-bold">Manage Marks</h5>
                    <p class="small text-muted">Add, view, and edit marks.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="studyplan.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-journal-bookmark-fill display-4 text-dark"></i></div>
                    <h5 class="fw-bold">Manage Study Plans</h5>
                    <p class="small text-muted">Add, view, and edit study plans.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="assignment.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-journal-check display-4 text-secondary"></i></div>
                    <h5 class="fw-bold">Manage Assignments</h5>
                    <p class="small text-muted">Add, view, and edit assignments.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="resources.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-folder-fill display-4 text-info"></i></div>
                    <h5 class="fw-bold">Manage Resources</h5>
                    <p class="small text-muted">Add, view, and edit resources.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="attendance.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-calendar-check-fill display-4 text-warning"></i></div>
                    <h5 class="fw-bold">Manage Attendance</h5>
                    <p class="small text-muted">Add, view, and edit attendance.</p>
                </div>
            </a>
        </div>
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
