<?php
session_start();
require_once "../classes/Applications.php";
require_once "../classes/Profile.php";
require_once "../classes/Scholarship.php";

// Admin check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../global/login.php");
    exit();
}

$appObj = new Application();
$profileObj = new Profile();
$scholarObj = new Scholarship();

// Summary counts
$totalStudents = $profileObj->countProfiles();
$totalScholarships = $scholarObj->countScholarships();
$totalApplications = $appObj->countApplications();
$totalApproved = $appObj->countApplicationsByStatus('Approved');
$totalRejected = $appObj->countApplicationsByStatus('Rejected');

// Recent applications
$recentApps = $appObj->getRecentApplications(10);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Reports</title>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<!-- Navigation Bar -->
<nav>
  <div class="nav-container">
    <div class="nav-logo">
      <img src="https://cdn-icons-png.flaticon.com/512/1828/1828911.png" alt="Admin Icon">
      Admin Dashboard
    </div>

    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-icon">☰</label>

    <div class="nav-links">
      <a href="dashboard.php">Overview</a>
      <a href="scholarmanagement.php">Scholarship Management</a>
      <a href="reviewapprove.php">Review & Approval</a>
      <a href="reports.php"  class="active">Reports</a>
    </div>

    <div class="profile">

    <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-nav">
    <h2>Admin Reports</h2>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card">Total Students: <?= $totalStudents ?></div>
        <div class="card">Total Scholarships: <?= $totalScholarships ?></div>
        <div class="card">Total Applications: <?= $totalApplications ?></div>
        <div class="card">Approved: <?= $totalApproved ?></div>
        <div class="card">Rejected: <?= $totalRejected ?></div>
    </div>

    <!-- Recent Applications -->
    <h3>Recent Applications</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Scholarship</th>
                <th>Status</th>
                <th>Applied At</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($recentApps as $index => $app): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($app['firstName'] . ' ' . $app['lastName']) ?></td>
                <td><?= htmlspecialchars($app['scholarship_title']) ?></td>
                <td class="status-<?= strtolower($app['status']) ?>"><?= htmlspecialchars($app['status']) ?></td>
                <td><?= htmlspecialchars($app['applied_at']) ?></td>
                <td>
                    <?php if($app['upload_file']): ?>
                        <a href="../uploads/applications/<?= htmlspecialchars($app['upload_file']) ?>" target="_blank">View</a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
<script src="../global/scripts.min.js"></script>
</html>
