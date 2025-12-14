<?php
session_start();
require_once "../classes/scholarship.php";
require_once "../classes/Applications.php";
require_once "../classes/Profile.php";

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../global/login.php");
    exit();
}

// Get student info
$student_id = $_SESSION['user_id'];
$profileObj = new Profile();
$studentProfile = $profileObj->viewProfile($student_id);
$studentGPA = isset($studentProfile['gpa']) ? floatval($studentProfile['gpa']) : 0.0;

$scholarObj = new Scholarship();
$appObj = new Application(); // Correct class name

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$scholarships = $scholarObj->getScholarships($limit, $offset);
$total = $scholarObj->countScholarships();
$totalPages = ceil($total / $limit);

// Handle file upload and application submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scholarship_id'])) {
    $scholarship_id = intval($_POST['scholarship_id']);
    $scholarship = $scholarObj->getScholarshipById($scholarship_id);

    if (!$scholarship) {
        die("<script>alert('Scholarship not found'); window.location.href='browsescholarships.php';</script>");
    }

    // GPA check
    if ($studentGPA < $scholarship['min_gpa']) {
        echo "<script>alert('Your GPA (" . number_format($studentGPA,2) . ") does not meet the minimum requirement of " . number_format($scholarship['min_gpa'],2) . "');</script>";
    } 
    // Already applied check
    elseif ($appObj->hasApplied($student_id, $scholarship_id)) {
        echo "<script>alert('You have already applied for this scholarship');</script>";
    } 
    else {
        // File upload
        if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['upload_file']['tmp_name'];
            $fileName = $_FILES['upload_file']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg','jpeg','png','pdf'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                echo "<script>alert('Invalid file type. Only JPG, PNG, PDF allowed');</script>";
            } else {
                $newFileName = $student_id . "_" . time() . "." . $fileExtension;
                $uploadDir = "../uploads/applications/";
                if (!is_dir($uploadDir)) mkdir($uploadDir,0777,true);
                $uploadedFilePath = $uploadDir . $newFileName;
                move_uploaded_file($fileTmpPath, $uploadedFilePath);

                // Save application
                $appObj->student_id = $student_id;
                $appObj->scholarship_id = $scholarship_id;
                $appObj->upload_file = $uploadedFilePath;
                $appObj->status = 'Pending';
                $appObj->applied_at = date('Y-m-d H:i:s');
                $appObj->addApplication();

                echo "<script>alert('Application submitted successfully!'); window.location.href='tracking.php';</script>";
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Browse Scholarships</title>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<nav>
  <div class="nav-container">
    <div class="nav-logo">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Scholarship Icon">
      Scholarship Portal
    </div>
    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-icon">☰</label>
    <div class="nav-links">
        <a href="studash.php">Dashboard</a>
        <a href="browsescholarships.php" class="active">Browse Scholarships</a>
        <a href="tracking.php">Tracking</a>
        <a href="notifications.php">Notifications</a>
        <a href="studentprofile.php">Profile</a>
    </div>
    <div class="profile">
    <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<div style="padding:20px;">
    <h2>Available Scholarships</h2>
    <?php if (empty($scholarships)) : ?>
        <p>No scholarships available.</p>
    <?php else: ?>
        <?php foreach ($scholarships as $sch) : ?>
            <div class="scholarship-card">
                <h3><?= htmlspecialchars($sch['title']) ?></h3>
                <p><strong>Description:</strong> <?= htmlspecialchars($sch['description']) ?></p>
                <p><strong>Requirements:</strong> <?= htmlspecialchars($sch['requirements']) ?></p>
                <p><strong>Minimum GPA:</strong> <?= number_format($sch['min_gpa'],2) ?></p>
                <p><strong>Deadline:</strong> <?= htmlspecialchars($sch['deadline']) ?></p>
                <button class="apply-btn" onclick="openModal(<?= $sch['scholarship_id'] ?>, <?= $sch['min_gpa'] ?>)">Apply</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($totalPages > 1) : ?>
        <div class="pagination">
            <?php for ($i=1; $i<=$totalPages; $i++): ?>
                <?php if($i==$page): ?>
                    <span class="current"><?= $i ?></span>
                <?php else: ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="applyModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Upload Document</h3>
        <form id="applyForm" method="post" enctype="multipart/form-data">
            <input type="file" name="upload_file" id="upload_file" required>
            <p id="fileName" style="font-size:0.9em;color:#555;margin-bottom:10px;"></p>
            <input type="hidden" name="scholarship_id" id="scholarship_id">
            <button type="submit">Submit Application</button>
        </form>
    </div>
</div>

<script>
const studentGPA = <?= $studentGPA ?>;

// Open modal with GPA check
function openModal(scholarshipId, minGPA){
    if(studentGPA < minGPA){
        alert(`Your GPA (${studentGPA.toFixed(2)}) does not meet the minimum requirement of ${minGPA.toFixed(2)}`);
        return;
    }
    document.getElementById('scholarship_id').value = scholarshipId;
    document.getElementById('applyModal').style.display = 'flex';
}

// Close modal
function closeModal(){
    document.getElementById('applyModal').style.display = 'none';
    document.getElementById('fileName').textContent = '';
    document.getElementById('upload_file').value = '';
}

// Show selected file name
document.getElementById('upload_file').addEventListener('change', function() {
    const file = this.files[0];
    if(file){
        document.getElementById('fileName').textContent = "Selected file: " + file.name;
    } else {
        document.getElementById('fileName').textContent = '';
    }
});
</script>

</body>
<script src="../global/scripts.min.js"></script>
</html>
