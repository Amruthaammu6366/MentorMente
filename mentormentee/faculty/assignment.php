<?php
// Faculty Add/View/Delete Assignment
session_start();
if (!isset($_SESSION['faculty_id'])) { header('Location: login.php'); exit; }
require_once '../config/db.php';
$faculty_id = $_SESSION['faculty_id'];

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    // Remove file from server
    $get = $conn->query("SELECT file_path FROM assignment WHERE id=$del_id AND faculty_id=$faculty_id");
    if ($get && $row = $get->fetch_assoc()) {
        if ($row['file_path'] && file_exists('../uploads/'.$row['file_path'])) unlink('../uploads/'.$row['file_path']);
    }
    $conn->query("DELETE FROM assignment WHERE id=$del_id AND faculty_id=$faculty_id");
    header('Location: assignment.php'); exit;
}

// Handle Add Assignment
$err = $succ = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject'])) {
    $subject = $conn->real_escape_string($_POST['subject']);
    $from_date = $conn->real_escape_string($_POST['from_date']);
    $to_date = $conn->real_escape_string($_POST['to_date']);
    $semester = intval($_POST['semester']);
    $desc = $conn->real_escape_string($_POST['description']);
    $filename = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fname = time().'_'.basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/'.$fname)) {
            $filename = $fname;
        }
    }
    $conn->query("INSERT INTO assignment (faculty_id, subject, from_date, to_date, file_path, semester, description) VALUES ($faculty_id, '$subject', '$from_date', '$to_date', '$filename', $semester, '$desc')");
    $succ = 'Assignment added successfully!';
}

// Fetch assignments by this faculty
$assignments = $conn->query("SELECT * FROM assignment WHERE faculty_id=$faculty_id ORDER BY from_date DESC, to_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment - MENTOR MENTEE</title>
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
        <li class="nav-item"><a class="nav-link active" href="assignment.php">Assignment</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
<h4 class="mb-4 mt-5 text-decoration-underline link-offset-1">Manage Assignment</h4>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card p-4 mb-4"> 
                <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
                <?php if($succ): ?><div class="alert alert-success"><?php echo $succ; ?></div><?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <select name="semester" class="form-select" required>
                                <option value="">Select Semester</option>
                                <?php for($i=1;$i<=8;$i++): ?>
                                <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <textarea name="description" class="form-control" placeholder="Description" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-5 mt-4">
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                    <button class="btn btn-primary w-100">Add Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card p-4 mb-4">
                <h5>All Assignments</h5>
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Subject</th><th>From</th><th>To</th><th>File</th><th>Description</th><th>Semester</th><th>Delete</th>
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
                            <td><?php echo htmlspecialchars($a['semester']); ?></td>
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
        if(!confirm('Delete this assignment?')) e.preventDefault();
    });
    // DataTables for all tables
    $('table').DataTable();
});
</script>
</body>
</html>
