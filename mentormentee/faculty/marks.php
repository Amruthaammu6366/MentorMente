<?php
// Faculty Add/View/Delete Marks
session_start();
if (!isset($_SESSION['faculty_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$faculty_id = $_SESSION['faculty_id'];

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM marks WHERE id=$del_id AND faculty_id=$faculty_id");
    header('Location: marks.php'); exit;
}

// Get selected semester (for displaying students)
$selected_sem = isset($_GET['semester']) ? intval($_GET['semester']) : '';

// Handle Add Marks
$err = $succ = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['testname'])) {
    $testname = $conn->real_escape_string($_POST['testname']);
    $date = $conn->real_escape_string($_POST['date']);
    $total_marks = intval($_POST['total_marks']);
    $semester = intval($_POST['semester']);
    $student_ids = isset($_POST['student_id']) ? $_POST['student_id'] : [];
    $marks = isset($_POST['marks']) ? $_POST['marks'] : [];
    $invalid = false;
    foreach ($marks as $m) {
        if (intval($m) > $total_marks) {
            $invalid = true;
            break;
        }
    }
    if (count($student_ids) === 0) {
        $err = 'No students found for the selected semester.';
    } elseif ($invalid) {
        $err = 'One or more student marks exceed the total marks.';
    } else {
        foreach ($student_ids as $idx => $sid) {
            $m = intval($marks[$idx]);
            $conn->query("INSERT INTO marks (faculty_id, student_id, testname, date, total_marks, semester, marks) VALUES ($faculty_id, $sid, '$testname', '$date', $total_marks, $semester, $m)");
        }
        $succ = 'Marks added successfully!';
    }
}

// Fetch students for dropdown
$students = $conn->query("SELECT id, name, semester FROM student ORDER BY semester, name");

// Fetch students for the selected semester
$students_in_sem = false;
if ($selected_sem) {
    $students_in_sem = $conn->query("SELECT id, name FROM student WHERE semester=$selected_sem ORDER BY name");
}

// Fetch marks by this faculty
$marks = $conn->query("SELECT m.*, s.name as student_name FROM marks m JOIN student s ON m.student_id = s.id WHERE m.faculty_id=$faculty_id ORDER BY m.date DESC, m.testname");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link active" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link" href="studyplan.php">Study Plan</a></li>
        <li class="nav-item"><a class="nav-link" href="assignment.php">Assignment</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Manage Marks</h4>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card p-4 mb-4"> 
                <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
                <?php if($succ): ?><div class="alert alert-success"><?php echo $succ; ?></div><?php endif; ?>
                <?php if($students && $students->num_rows > 0): ?>
                <form method="get" class="mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-8">
                            <label for="semester" class="form-label">Select Semester</label>
                            <select name="semester" id="semester" class="form-select" required onchange="this.form.submit()">
                                <option value="">Select Semester</option>
                                <?php for($i=1;$i<=8;$i++): ?>
                                <option value="<?php echo $i; ?>" <?php if($selected_sem==$i) echo 'selected'; ?>>Semester <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100" type="submit">Show Students</button>
                        </div>
                    </div>
                </form>
                <?php if($selected_sem && $students_in_sem && $students_in_sem->num_rows > 0): ?>
                <form method="post">
                    <input type="hidden" name="semester" value="<?php echo $selected_sem; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="testname" class="form-control" placeholder="Test Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="total_marks" class="form-control" placeholder="Total Marks" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="form-label">Enter Marks for Students</label>
                        <table class="table table-bordered bg-white">
                            <thead><tr><th>Student Name</th><th>Marks</th></tr></thead>
                            <tbody>
                            <?php foreach($students_in_sem as $stu): ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="student_id[]" value="<?php echo $stu['id']; ?>">
                                        <?php echo htmlspecialchars($stu['name']); ?>
                                    </td>
                                    <td><input type="number" name="marks[]" class="form-control marks-input" min="0" placeholder="Marks" required></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex gap-5 mt-4">
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                    <button class="btn btn-primary w-100">Add Marks</button>
                    </div>
                </form>
                <?php elseif($selected_sem): ?>
                <div class="alert alert-warning text-center mb-0">No students found for selected semester.</div>
                <?php endif; ?>
                <?php else: ?>
                <div class="alert alert-warning text-center mb-0">No students available to add marks.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card p-4 mb-4">
                <h5>All Marks</h5>
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Test Name</th><th>Date</th><th>Total</th><th>Semester</th><th>Student</th><th>Marks</th><th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($marks && $marks->num_rows): foreach($marks as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['testname']); ?></td>
                            <td><?php echo htmlspecialchars($m['date']); ?></td>
                            <td><?php echo htmlspecialchars($m['total_marks']); ?></td>
                            <td><?php echo htmlspecialchars($m['semester']); ?></td>
                            <td><?php echo htmlspecialchars($m['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($m['marks']); ?></td>
                            <td><a href="?delete=<?php echo $m['id']; ?>" class="btn btn-sm btn-danger btn-del">Delete</a></td>
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
        if(!confirm('Delete this marks entry?')) e.preventDefault();
    });
    // Dynamic max for marks input
    $('input[name="total_marks"]').on('input', function() {
        var max = parseInt($(this).val()) || 0;
        $('.marks-input').attr('max', max);
    }).trigger('input');
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
