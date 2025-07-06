<?php
// index.php - Stylish Home Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTOR MENTEE Portal</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <style>
        body {
            background: url('images/home.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            background: transparent;
            min-height: 100vh;
        }
        .home-card {
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            border-radius: 1rem;
        }
        .navbar {
            background: rgba(255,255,255,0.92) !important;
        }
    </style>
</head>
<body>
<div class="overlay">
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">MENTOR MENTEE</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="faculty/login.php">Faculty Login</a></li>
        <li class="nav-item"><a class="nav-link" href="student/login.php">Student Login</a></li>
        <li class="nav-item"><a class="nav-link" href="parent/login.php">Parent Login</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin Login</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card home-card p-4 text-center my-4"> <h2 class="fw-bold mb-3">Welcome to Mentor Mentee</h2>
                <p class="lead mb-4">A modern portal for Faculty, Students, Parents, and Admins.<br>Click below to access your module.</p>
                <div class="d-grid gap-3">
                    <a href="faculty/login.php" class="btn btn-primary btn-lg">Faculty Module</a>
                    <a href="student/login.php" class="btn btn-success btn-lg">Student Module</a>
                    <a href="parent/login.php" class="btn btn-warning btn-lg">Parent Module</a>
                    <a href="admin/login.php" class="btn btn-dark btn-lg">Admin Module</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
