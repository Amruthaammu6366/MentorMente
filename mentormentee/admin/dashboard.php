<?php
// Admin Dashboard
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MENTOR MENTEE</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../index.php">MENTOR MENTEE</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
        <li class="nav-item"><a class="nav-link" href="faculty.php">Faculty</a></li>
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
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center text-primary">Welcome, Admin!</h2>
    <div class="row g-4 justify-content-center my-4">
        <div class="col-md-3">
            <a href="students.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-people-fill display-4 text-primary"></i></div>
                    <h5 class="fw-bold">Manage Students</h5>
                    <p class="small text-muted">view and manage student records.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="faculty.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-person-badge-fill display-4 text-success"></i></div>
                    <h5 class="fw-bold">Manage Faculty</h5>
                    <p class="small text-muted">view and manage faculty records.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="attendance.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-calendar-check-fill display-4 text-warning"></i></div>
                    <h5 class="fw-bold">Manage Attendance</h5>
                    <p class="small text-muted">view and manage attendance records.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="marks.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-clipboard-data-fill display-4 text-danger"></i></div>
                    <h5 class="fw-bold">Manage Marks</h5>
                    <p class="small text-muted">view and manage marks.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="resources.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-folder-fill display-4 text-info"></i></div>
                    <h5 class="fw-bold">Manage Resources</h5>
                    <p class="small text-muted">view and manage resources.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="assignments.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-journal-check display-4 text-secondary"></i></div>
                    <h5 class="fw-bold">Manage Assignments</h5>
                    <p class="small text-muted">view and manage assignments.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="studyplans.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-journal-bookmark-fill display-4 text-dark"></i></div>
                    <h5 class="fw-bold">Manage Study Plans</h5>
                    <p class="small text-muted">view and manage study plans.</p>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
