<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Navbar</title>
<link rel="stylesheet" href="../css/styles.css">
<style>
.container {
    max-width: 95%;
    margin: 20px auto;
    padding: 0 15px;
}
.cards {
    display: flex;
    flex-direction: column; /* Stack cards vertically */
    gap: 15px;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 6px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.12);
}

.card h3 {
    margin-bottom: 8px;
}

.card p, .card ul {
    margin: 5px 0;
}

.card ul {
    padding-left: 20px;
}
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
        <a href="studash.php" class="active">Dashboard</a>
        <a href="browsescholarships.php">Browse Scholarships</a>
        <a href="tracking.php">Tracking</a>
        <a href="notifications.php">Notifications</a>
        <a href="studentprofile.php">Profile</a>
    </div>


    <div class="profile">
    <a href="../global/logout.php" class="logout">Logout</a>
    </div>
  </div>
</nav>

<!-- Page content would start here -->
<div class="container mt-nav">
    <h2>Student Overview</h2>
    <div class="cards">

        <!-- Recent Scholarships -->
        <div class="card" onclick="location.href='browsescholarships.php'">
            <h3>Scholarships</h3>
            <p>Click to view all scholarships</p>
        </div>

        <!-- My Applications -->
        <div class="card" onclick="location.href='tracking.php'">
            <h3>My Applications</h3>
            <p>Click to track your applications</p>
        </div>

        <!-- Notifications -->
        <div class="card" onclick="location.href='notifications.php'">
            <h3>Notifications</h3>
            <p>Click to view all notifications</p>
        </div>

    </div>
</div>
</body>
<script src="../global/scripts.min.js"></script>
</html>