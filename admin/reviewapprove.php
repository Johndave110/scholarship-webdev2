<?php
session_start();
require_once "../classes/Applications.php";
require_once "../classes/Users.php";
require_once "../classes/Scholarship.php";

// Ensure admin is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../global/login.php");
    exit();
}

$appObj = new Application();
$userObj = new Users();
$scholarObj = new Scholarship();

// Fetch all applications with student name and scholarship title
$applications = $appObj->getAllApplicationsWithDetails();

// Handle approve/reject actions
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])){
    $appId = intval($_POST['application_id']);
    if(isset($_POST['approve'])){
        $appObj->updateStatus($appId, 'Approved');
    } elseif(isset($_POST['reject'])){
        $appObj->updateStatus($appId, 'Rejected');
    }
    header("Location: reviewapprove.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Review & Approval</title>
<link rel="stylesheet" href="../css/styles.css">
<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
.status-pending { color: orange; font-weight: bold; }
.status-approved { color: green; font-weight: bold; }
.status-rejected { color: red; font-weight: bold; }
.action-btn {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: #fff;
}
.approve { background-color: #28a745; }
.reject { background-color: #dc3545; }
</style>
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
      <a href="scholarmanagement.php">Scholarship Management</a>
      <a href="reviewapprove.php" class="active">Review & Approval</a>
      <a href="reports.php">Reports</a>
    </div>

    <div class="profile">

    <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-nav">
    <h2>Applications List</h2>
    <?php if(empty($applications)): ?>
        <p>No applications submitted yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Scholarship</th>
                    <th>Uploaded File</th>
                    <th>Status</th>
                    <th>Applied At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($applications as $index => $app): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($app['firstName'] . " " . $app['lastName']) ?></td>
                    <td><?= htmlspecialchars($app['scholarship_title']) ?></td>
                    <td>
                        <?php if($app['upload_file']): ?>
                            <a href="../uploads/applications/<?= htmlspecialchars($app['upload_file']) ?>" target="_blank">View</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td class="status-<?= strtolower($app['status']) ?>"><?= htmlspecialchars($app['status']) ?></td>
                    <td><?= htmlspecialchars($app['applied_at']) ?></td>
                    <td>
                        <?php if($app['status'] === 'Pending'): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                <button name="approve" class="action-btn approve">Approve</button>
                                <button name="reject" class="action-btn reject">Reject</button>
                            </form>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
<script src="../global/scripts.min.js"></script>
</html>
