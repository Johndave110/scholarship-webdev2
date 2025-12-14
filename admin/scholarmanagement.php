<?php
session_start();
// Admin check - protect this page
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
  header("Location: ../global/login.php");
  exit();
}

require_once "../classes/Scholarship.php";
$scholarObj = new Scholarship();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$scholarships = $scholarObj->getScholarships($limit, $offset);
$total = $scholarObj->countScholarships();
$totalPages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scholarship Management</title>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>

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
      <a href="scholarmanagement.php" class="active">Scholarship Management</a>
      <a href="reviewapprove.php">Review & Approval</a>
      <a href="reports.php">Reports</a>
    </div>

    <div class="profile">

      <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-nav">
  <h2>Scholarship Management</h2>
  <a href="addscholarship.php" class="add-btn">+ Add Scholarship</a>

    <table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Requirements</th>
        <th>Deadline</th>
        <th>Total Slots</th>
        <th>Available Slots</th>
        <th>Min GPA</th>
        <th>Actions</th>
    </tr>
    <?php foreach($scholarships as $sch): ?>
    <tr>
        <td><?= htmlspecialchars($sch['title']) ?></td>
        <td><?= htmlspecialchars($sch['description']) ?></td>
        <td><?= htmlspecialchars($sch['requirements']) ?></td>
        <td><?= htmlspecialchars($sch['deadline']) ?></td>
        <td><?= htmlspecialchars($sch['total_slots']) ?></td>
        <td><?= htmlspecialchars($sch['available_slots']) ?></td>
        <td><?= htmlspecialchars($sch['min_gpa']) ?></td>
        <td>
            <a href="editscholarship.php?id=<?= $sch['scholarship_id'] ?>">Edit</a> |
            <a href="deletescholarship.php?id=<?= $sch['scholarship_id'] ?>" onclick="return confirm('Delete this scholarship?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>

</body>
<script src="../global/scripts.min.js"></script>
</html>
