<?php
// Parent Login Page (by phone)
session_start();
require_once '../config/db.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);
    $sql = "SELECT * FROM student WHERE parent_phone='$phone'";
    $res = $conn->query($sql);
    if ($res && $res->num_rows === 1) {
        $_SESSION['parent_phone'] = $phone;
        $_SESSION['parent_student_id'] = $res->fetch_assoc()['id'];
        header('Location: dashboard.php'); exit;
    } else {
        $err = 'Invalid phone number!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Login - MENTOR MENTEE</title>
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
            <h3 class="mb-3 text-center">Parent Login</h3>
            <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Registered Phone Number" required>
                </div>
                <button class="btn btn-warning w-100">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
