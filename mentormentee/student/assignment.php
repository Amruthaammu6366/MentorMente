<?php
// Student View & Submit Assignment
session_start();
if (!isset($_SESSION['student_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$student_id = $_SESSION['student_id'];
// Get student's semester
$stu = $conn->query("SELECT semester FROM student WHERE id=$student_id");
$semester = $stu && $stu->num_rows ? $stu->fetch_assoc()['semester'] : 1;
$succ = $err = '';
// Handle assignment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_assignment_id'])) {
    $aid = intval($_POST['submit_assignment_id']);
    $filename = '';
    if (isset($_FILES['submission']) && $_FILES['submission']['error'] == 0) {
        $fname = time().'_'.basename($_FILES['submission']['name']);
        if (move_uploaded_file($_FILES['submission']['tmp_name'], '../uploads/'.$fname)) {
            $filename = $fname;
        }
    }
    // Save submission path in DB (assignment_submissions table)
    if ($filename) {
        $conn->query("REPLACE INTO assignment_submissions (student_id, assignment_id, file_path) VALUES ($student_id, $aid, '$filename')");
        $succ = 'Assignment submitted successfully!';
    } else {
        $err = 'File upload failed!';
    }
}
// Fetch assignments for this student's semester
$assignments = $conn->query("SELECT a.*, f.name as faculty_name FROM assignment a JOIN faculty f ON a.faculty_id = f.id WHERE a.semester=$semester ORDER BY a.from_date DESC, a.to_date DESC");
// Fetch submitted assignments
$subs = [];
$subq = $conn->query("SELECT assignment_id, file_path FROM assignment_submissions WHERE student_id=$student_id");
if ($subq && $subq->num_rows) { foreach($subq as $s) { $subs[$s['assignment_id']] = $s['file_path']; } }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link" href="studyplan.php">Study Plan</a></li>  
        <li class="nav-item"><a class="nav-link active" href="assignment.php">Assignments</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="marks.php">Marks</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Assignments</h4>
    <div class="card p-4 mb-4 mt-5">
        <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
        <?php if($succ): ?><div class="alert alert-success"><?php echo $succ; ?></div><?php endif; ?>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Subject</th><th>From</th><th>To</th><th>File</th><th>Description</th><th>Faculty</th><th>Submission</th>
                </tr>
            </thead>
            <tbody>
            <?php if($assignments && $assignments->num_rows): foreach($assignments as $a): ?>
                <tr>
                    <td><?php echo htmlspecialchars($a['subject']); ?></td>
                    <td><?php echo htmlspecialchars($a['from_date']); ?></td>
                    <td><?php echo htmlspecialchars($a['to_date']); ?></td>
                    <td><?php if($a['file_path']): ?><a href="../uploads/<?php echo $a['file_path']; ?>" target="_blank">View</a><?php endif; ?></td>
                    <td><?php echo htmlspecialchars($a['description']); ?></td>
                    <td><?php echo htmlspecialchars($a['faculty_name']); ?></td>
                    <td>
                        <?php if(isset($subs[$a['id']])): ?>
                            <a href="../uploads/<?php echo $subs[$a['id']]; ?>" target="_blank"><span class="badge bg-success">Submitted</span></a>
                        <?php else: ?>
                            <button class="btn btn-sm btn-primary btn-submit" data-id="<?php echo $a['id']; ?>">Submit</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; else: ?> 
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal for submission -->
<div class="modal fade" id="submitModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Submit Assignment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="submit_assignment_id" id="submit_assignment_id">
          <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" name="submission" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(function(){
    // DataTables for all tables
    $('table').DataTable();
    $('.btn-submit').on('click', function(){
        var aid = $(this).data('id');
        $('#submit_assignment_id').val(aid);
        $('#submitModal').modal('show');
    });
});
</script>
</body>
</html>
