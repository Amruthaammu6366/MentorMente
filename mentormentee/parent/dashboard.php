<?php
// Parent Dashboard
session_start();
if (!isset($_SESSION['parent_phone']) || !isset($_SESSION['parent_student_id'])) { header('Location: login.php'); exit; }
$student_id = $_SESSION['parent_student_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center text-primary">Welcome, Parent!</h2>
    <div class="row g-4 justify-content-center my-4">
        <div class="col-md-4">
            <a href="attendance.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-calendar-check-fill display-4 text-warning"></i></div>
                    <h5 class="fw-bold">View Attendance</h5>
                    <p class="small text-muted">Check your child's attendance records.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="marks.php" class="text-decoration-none">
                <div class="card shadow-lg border-0 p-4 text-center bg-light h-100">
                    <div class="mb-2"><i class="bi bi-clipboard-data-fill display-4 text-danger"></i></div>
                    <h5 class="fw-bold">View Marks</h5>
                    <p class="small text-muted">See your child's marks and performance.</p>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
