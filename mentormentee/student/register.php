<?php
// Student Register Page
require_once '../config/db.php';
$err = $succ = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = (trim($_POST['password']));
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $name = trim($_POST['name']);
    $semester = intval($_POST['semester']);
    $usn = trim($_POST['usn']);
    $parent_phone = trim($_POST['parent_phone']);
    $parent_name = trim($_POST['parent_name']);
    $exists = $conn->query("SELECT id FROM student WHERE username='$username'");
    if ($exists && $exists->num_rows > 0) {
        $err = 'Username already exists!';
    } else {
        $sql = "INSERT INTO student (username, password, email, phone, address, name, semester, usn, parent_phone, parent_name) VALUES ('$username', '$password', '$email', '$phone', '$address', '$name', $semester, '$usn', '$parent_phone', '$parent_name')";
        if ($conn->query($sql)) {
            $succ = 'Registration successful! You can login now.';
        } else {
            $err = 'Registration failed!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex align-items-center justify-content-center" style="min-height:90vh;">
    <div class="col-md-7">
        <div class="card p-4 shadow-lg">
            <h3 class="mb-3 text-center">Student Register</h3>
            <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
            <?php if($succ): ?><div class="alert alert-success"><?php echo $succ; ?></div><?php endif; ?>
            <form method="post">
                <div class="row g-2">
                <div class="col-md-6 mb-2"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
                    <div class="col-md-6 mb-2"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
                    <div class="col-md-6 mb-2"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
                    <div class="col-md-6 mb-2"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                    <div class="col-md-6 mb-2"><input type="text" name="phone" class="form-control" placeholder="Phone" required pattern="[6-9]{1}[0-9]{9}" title="Enter a valid 10-digit phone number starting with 6, 7, 8, or 9"></div>
                    <div class="col-md-6 mb-2"><input type="text" name="address" class="form-control" placeholder="Address" required></div>
                    <div class="col-md-6 mb-2"><input type="text" name="usn" class="form-control" placeholder="USN" required></div>
                    <div class="col-md-6 mb-2">
                        <select name="semester" class="form-select" required>
                            <option value="">Semester</option>
                            <?php for($i=1;$i<=8;$i++): ?>
                            <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2"><input type="text" name="parent_phone" class="form-control" placeholder="Parent Phone" required pattern="[6-9]{1}[0-9]{9}" title="Enter a valid 10-digit phone number starting with 6, 7, 8, or 9"></div>
                    <div class="col-md-6 mb-2"><input type="text" name="parent_name" class="form-control" placeholder="Parent Name" required></div>
                </div>
                <button class="btn btn-success w-100 mt-3">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
