<?php
session_start();
require_once "../classes/Profile.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../global/login.php");
    exit();
}

$profileObj = new Profile();
$profile = $profileObj->viewProfile($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile</title>
<link rel="stylesheet" href="../css/styles.css">
<style></style>
</head>
<body>

<!-- ✅ Shared Navigation -->
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
      <a href="notifications.php">Notifications</a>
      <a href="studentprofile.php" class="active">Profile</a> <!-- ✅ Highlight current page -->
    </div>

    <div class="profile">
      <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<!-- ✅ Main Profile Section -->
<div class="profile-container">
  <h2>My Profile</h2>

  <?php if ($profile): ?>
    <p><strong>First Name:</strong> <?= htmlspecialchars($profile['firstName']) ?></p>
    <p><strong>Last Name:</strong> <?= htmlspecialchars($profile['lastName']) ?></p>
    <p><strong>Middle Name:</strong> <?= htmlspecialchars($profile['middleName'] ?? '') ?></p>
    <p><strong>Birthdate:</strong> <?= htmlspecialchars($profile['birthdate']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($profile['address']) ?></p>
    <p><strong>Contact Number:</strong> <?= htmlspecialchars($profile['contactNumber']) ?></p>
    <p><strong>GPA:</strong> <?= htmlspecialchars($profile['gpa']) ?></p>
    <p><strong>Family Income:</strong> <?= htmlspecialchars($profile['familyIncome']) ?></p>
    <p><strong>School:</strong> <?= htmlspecialchars($profile['school']) ?></p>
    <p><strong>Course:</strong> <?= htmlspecialchars($profile['course']) ?></p>
    <p><strong>Year Level:</strong> <?= htmlspecialchars($profile['yearLevel']) ?></p>

    <div class="buttons">
      <a href="edit_profile.php" class="btn edit">Edit Profile</a>
      <a href="studash.php" class="btn back">Back to Dashboard</a>
    </div>

  <?php else: ?>
    <p>No profile found.</p>
  <?php endif; ?>
</div>

</body>
<script src="../global/scripts.min.js"></script>
</html>