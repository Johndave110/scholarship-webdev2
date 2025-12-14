<?php
session_start();
require_once "../classes/Applications.php";

// Ensure student is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student'){
    header("Location: ../global/login.php");
    exit();
}

$appObj = new Application();
$student_id = $_SESSION['user_id'];

// Get all applications for this student
$applications = $appObj->getApplicationsByStudent($student_id);

// Filter notifications: show only approved/rejected applications
$notifications = array_filter($applications, function($app){
    return in_array($app['status'], ['Approved', 'Rejected']);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notifications</title>
<link rel="stylesheet" href="../css/styles.css">
<style>
.notification {
    background: #fff;
    padding: 15px;
    margin: 10px 0;
    border-left: 5px solid;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.notification.approved { border-color: #28a745; }
.notification.rejected { border-color: #dc3545; }
.notification p { margin: 0; }
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
        <a href="tracking.php">Tracking</a>
        <a href="notifications.php"  class="active">Notifications</a>
        <a href="studentprofile.php">Profile</a>
    </div>

    <div class="profile">
    <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<div style="padding: 20px;">
    <h2>Notifications</h2>

    <?php if(empty($notifications)): ?>
        <p>No notifications at this time.</p>
    <?php else: ?>
        <?php foreach($notifications as $notif): ?>
            <div class="notification <?= strtolower($notif['status']) ?>">
                <p>
                    Your application for <strong><?= htmlspecialchars($notif['scholarship_title']) ?></strong> 
                    has been <strong><?= htmlspecialchars($notif['status']) ?></strong> on <?= htmlspecialchars($notif['applied_at']) ?>.
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
<script src="../global/scripts.min.js"></script>
</html>
