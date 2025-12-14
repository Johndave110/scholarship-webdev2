<?php
session_start();
require_once "../classes/Applications.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student'){
    header("Location: ../global/login.php");
    exit();
}

$appObj = new Application();
$student_id = $_SESSION['user_id'];

$applications = $appObj->getApplicationsByStudent($student_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Application Tracking</title>
<link rel="stylesheet" href="../css/styles.css">
<style>
/* Table styles */
table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
th { background-color: #f2f2f2; }
.status-pending { color: orange; font-weight: bold; }
.status-approved { color: green; font-weight: bold; }
.status-rejected { color: red; font-weight: bold; }
.action-btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; color: #fff; }
.approve { background-color: #28a745; }
.reject { background-color: #dc3545; }
</style>
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
        <a href="browsescholarships.php">Browse Scholarships</a>
        <a href="tracking.php"  class="active">Tracking</a>
        <a href="notifications.php">Notifications</a>
        <a href="studentprofile.php">Profile</a>
    </div>

    <div class="profile">
    <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<div style="padding: 20px;">
    <h2>My Applications</h2>

    <?php if(empty($applications)): ?>
        <p>You haven't applied to any scholarships yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Scholarship</th>
                    <th>Status</th>
                    <th>Uploaded File</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($applications as $index => $app): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($app['scholarship_title']) ?></td>
                    <td class="status-<?= strtolower($app['status']) ?>"><?= htmlspecialchars($app['status']) ?></td>
                    <td>
                        <?php if($app['upload_file']): ?>
                            <a href="../uploads/applications/<?= htmlspecialchars($app['upload_file']) ?>" target="_blank" class="view-link">View</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($app['applied_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
<script src="../global/scripts.min.js"></script>
</html>
