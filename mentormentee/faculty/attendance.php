<?php
// Faculty Add/View/Delete Attendance
session_start();
if (!isset($_SESSION['faculty_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$faculty_id = $_SESSION['faculty_id'];

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM attendance WHERE id=$del_id AND faculty_id=$faculty_id");
    header('Location: attendance.php'); exit;
}

// Handle Add Attendance
$err = $succ = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject'])) {
    $subject = $conn->real_escape_string($_POST['subject']);
    $student_id = intval($_POST['student_id']);
    $total_classes = intval($_POST['total_classes']);
    $month = $conn->real_escape_string($_POST['month']);
    $year = intval($_POST['year']);
    $attended = intval($_POST['total_attended']);
    if ($attended > $total_classes) {
        $err = 'Total Attended cannot be greater than Total Classes per Month.';
    } else {
        $conn->query("INSERT INTO attendance (faculty_id, student_id, subject, total_classes, month, year, total_attended) VALUES ($faculty_id, $student_id, '$subject', $total_classes, '$month', $year, $attended)");
        $succ = 'Attendance added successfully!';
    }
}

// Fetch students for dropdown
$students = $conn->query("SELECT id, name, semester FROM student ORDER BY semester, name");

// Fetch attendance by this faculty
$att = $conn->query("SELECT a.*, s.name as student_name FROM attendance a JOIN student s ON a.student_id = s.id WHERE a.faculty_id=$faculty_id ORDER BY a.year DESC, a.month DESC, s.name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="studyplan.php">Study Plan</a></li>
        <li class="nav-item"><a class="nav-link" href="assignment.php">Assignment</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link active" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Manage Attendance</h4>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card p-4 mb-4"> 
                <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
                <?php if($succ): ?><div class="alert alert-success"><?php echo $succ; ?></div><?php endif; ?>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="col-md-6">
                            <select name="student_id" class="form-select" required>
                                <option value="">Select Student</option>
                                <?php if($students && $students->num_rows): foreach($students as $stu): ?>
                                <option value="<?php echo $stu['id']; ?>"><?php echo htmlspecialchars($stu['name']); ?> (Sem <?php echo $stu['semester']; ?>)</option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="total_classes" class="form-control" placeholder="Total Classes per Month" required>
                        </div>
                        <div class="col-md-6">
                            <select name="month" class="form-select" required>
                                <option value="">Select Month</option>
                                <?php foreach(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"] as $m): ?>
                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="year" class="form-control" placeholder="Year" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="total_attended" class="form-control" placeholder="Total Attended" required min="0">
                        </div>
                    </div>
                    <div class="d-flex gap-5 mt-4">
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                    <button class="btn btn-primary w-100">Add Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12   ">
            <div class="card p-4 mb-4">
                <h5>All Attendance</h5>
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Subject</th><th>Student</th><th>Total</th><th>Attended</th><th>Month</th><th>Year</th><th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($att && $att->num_rows): foreach($att as $a): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($a['subject']); ?></td>
                            <td><?php echo htmlspecialchars($a['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($a['total_classes']); ?></td>
                            <td><?php echo htmlspecialchars($a['total_attended']); ?></td>
                            <td><?php echo htmlspecialchars($a['month']); ?></td>
                            <td><?php echo htmlspecialchars($a['year']); ?></td>
                            <td><a href="?delete=<?php echo $a['id']; ?>" class="btn btn-sm btn-danger btn-del">Delete</a></td>
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
        if(!confirm('Delete this attendance entry?')) e.preventDefault();
    });
    // Dynamic max for attended input
    $('input[name="total_classes"]').on('input', function() {
        var max = parseInt($(this).val()) || 0;
        $('input[name="total_attended"]').attr('max', max);
    }).trigger('input');
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
