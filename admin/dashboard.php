<?php
session_start();
require_once "../classes/Profile.php";
require_once "../classes/Applications.php";
require_once "../classes/Scholarship.php";

// Admin check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../global/login.php");
    exit();
}

$profileObj = new Profile();
$appObj = new Application();
$scholarObj = new Scholarship();

// Fetch 3 latest scholarships
$recentScholarships = $scholarObj->getRecentScholarships(3); 

// Fetch recent pending applications (direct DB query for efficiency)
$pendingApplications = $appObj->getRecentApplicationsByStatus('Pending', 3);

// Fetch counts for reports card (KPIs)
$totalStudents = $profileObj->countProfiles();
$totalScholarships = $scholarObj->countScholarships();
$totalApplications = $appObj->countApplications();
$totalApproved = $appObj->countApplicationsByStatus('Approved');
$totalRejected = $appObj->countApplicationsByStatus('Rejected');
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard Overview</title>
<link rel="stylesheet" href="../css/styles.css">
    
</head>
<body class="admin-dashboard">

<nav>
<div class="nav-container">
<div class="nav-logo">
<img src="https://cdn-icons-png.flaticon.com/512/1828/1828911.png" alt="Admin Icon">
Admin Dashboard
</div>

<input type="checkbox" id="menu-toggle">
<label for="menu-toggle" class="menu-icon">☰</label>

<div class="nav-links">
    <a href="dashboard.php" class="active">Overview</a>
<a href="scholarmanagement.php">Scholarship Management</a>
<a href="reviewapprove.php">Review & Approval</a>
<a href="reports.php">Reports</a>
</div>

    <div class="profile">
    <a href="../global/logout.php" class="logout">Logout</a>
</div>
</div>
</nav>

<div class="container mt-nav">
<h2>Admin Overview</h2>

<div class="cards">

<div class="card" onclick="location.href='scholarmanagement.php'">
<h3>Scholarship Management</h3>
<ul>
<?php foreach($recentScholarships as $sch): ?>
<li><?= htmlspecialchars($sch['title']) ?></li>
<?php endforeach; ?>
</ul>
<p class="note">Click to manage</p>
</div>

<div class="card" onclick="location.href='reviewapprove.php'">
<h3>Review & Approval</h3>
<ul>
<?php if(empty($pendingApplications)): ?>
    <li>No pending applications</li>
<?php else: ?>
    <?php foreach($pendingApplications as $app): ?>
        <li><?= htmlspecialchars($app['firstName'].' '.$app['lastName']).' - '.htmlspecialchars($app['status']) ?></li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>
<p class="note">Click to review</p>
</div>

<div class="card" onclick="location.href='reports.php'">
<h3>Reports & Statistics</h3>
<p>Total Students: **<?= $totalStudents ?>**</p>
<p>Total Scholarships: **<?= $totalScholarships ?>**</p>
<hr>
<p>Total Applications: **<?= $totalApplications ?>**</p>
<p class="status approved">Approved: **<?= $totalApproved ?>**</p>
<p class="status rejected">Rejected: **<?= $totalRejected ?>**</p>
<p class="note">Click for details</p>
</div>

</div>
</div>
</body>
<script src="../global/scripts.min.js"></script>
</html>