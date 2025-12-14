<?php
require_once "../classes/Scholarship.php";
$scholarObj = new Scholarship();

$scholarship = [];
$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $scholarship["title"] = trim(htmlspecialchars($_POST["title"]));
    $scholarship["description"] = trim(htmlspecialchars($_POST["description"]));
    $scholarship["requirements"] = trim(htmlspecialchars($_POST["requirements"]));
    $scholarship["deadline"] = trim(htmlspecialchars($_POST["deadline"]));
    $scholarship["total_slots"] = trim(htmlspecialchars($_POST["total_slots"]));
    $scholarship["min_gpa"] = trim(htmlspecialchars($_POST["min_gpa"]));
    $scholarship["available_slots"] = $scholarship["total_slots"];

    if(empty($scholarship["title"])){
        $errors["title"] = "Scholarship title is required";
    } elseif($scholarObj->isScholarshipExist($scholarship["title"])){
        $errors["title"] = "Scholarship title already exists";
    }

    if(empty($scholarship["description"])){
        $errors["description"] = "Please enter a description";
    }

    if(empty($scholarship["requirements"])){
        $errors["requirements"] = "Requirements are required";
    }

    if(empty($scholarship["deadline"])){
        $errors["deadline"] = "Deadline is required";
    }

    if(!is_numeric($scholarship["total_slots"]) || $scholarship["total_slots"] < 0){
        $errors["total_slots"] = "Total slots must be a non-negative number";
    }

    if(!is_numeric($scholarship["min_gpa"]) || $scholarship["min_gpa"] < 0 || $scholarship["min_gpa"] > 5){
        $errors["min_gpa"] = "Please enter a valid GPA between 0 and 5";
    }

    if(empty($errors)){
        $scholarObj->title = $scholarship["title"];
        $scholarObj->description = $scholarship["description"];
        $scholarObj->requirements = $scholarship["requirements"];
        $scholarObj->deadline = $scholarship["deadline"];
        $scholarObj->total_slots = $scholarship["total_slots"];
        $scholarObj->available_slots = $scholarship["available_slots"];
        $scholarObj->min_gpa = $scholarship["min_gpa"];

        if($scholarObj->addScholarship()){
            echo "<script>alert('Scholarship added successfully!'); window.location.href='scholarmanagement.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error adding scholarship');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Scholarship</title>
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
    <a href="scholarmanagement.php" class="back-btn">Back to Scholarships</a>
    <h2>Add Scholarship</h2>

    <form action="" method="post">
        <label for="title">Scholarship Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= $scholarship["title"] ?? "" ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="description">Description <span>*</span></label>
        <textarea name="description" id="description"><?= $scholarship["description"] ?? "" ?></textarea>
        <p class="error"><?= $errors["description"] ?? "" ?></p>

        <label for="requirements">Document Requirements <span>*</span></label>
        <textarea name="requirements" id="requirements"><?= $scholarship["requirements"] ?? "" ?></textarea>
        <p class="error"><?= $errors["requirements"] ?? "" ?></p>

        <label for="min_gpa">Minimum GPA Requirement <span>*</span></label>
        <input type="number" step="0.01" name="min_gpa" id="min_gpa" value="<?= htmlspecialchars($scholarship["min_gpa"] ?? "") ?>">
        <p class="error"><?= $errors["min_gpa"] ?? "" ?></p>

        <label for="deadline">Deadline <span>*</span></label>
        <input type="date" name="deadline" id="deadline" value="<?= $scholarship["deadline"] ?? "" ?>">
        <p class="error"><?= $errors["deadline"] ?? "" ?></p>

        <label for="total_slots">Total Slots <span>*</span></label>
        <input type="number" name="total_slots" id="total_slots" value="<?= $scholarship["total_slots"] ?? "" ?>">
        <p class="error"><?= $errors["total_slots"] ?? "" ?></p>

        <div class="form-actions">
            <input type="submit" value="Save Scholarship">
        </div>
    </form>
</div>
</body>
<script src="../global/scripts.min.js"></script>
</html>