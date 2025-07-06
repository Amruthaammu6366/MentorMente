<?php
// Admin Login Page (hardcoded: admin/admin)
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php'); exit;
    } else {
        $err = 'Invalid credentials!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MENTOR MENTEE</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body style="background:url('../images/auth.jpg') no-repeat center center fixed; background-size:cover;">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../index.php">MENTOR MENTEE</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex align-items-center justify-content-center" style="min-height:90vh;">
    <div class="col-md-5">
        <div class="card p-4 shadow-lg">
            <h3 class="mb-3 text-center">Admin Login</h3>
            <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button class="btn btn-dark w-100">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
