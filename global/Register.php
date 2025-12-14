<?php
require_once "../classes/Profile.php";
$userObj = new Profile();

$profile = [];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users["firstName"] = trim(htmlspecialchars($_POST["firstName"]));
    $users["lastName"] = trim(htmlspecialchars($_POST["lastName"]));
    $users["middleName"] = trim(htmlspecialchars($_POST["middleName"]));
    $users["birthdate"] = trim(htmlspecialchars($_POST["birthdate"]));
    $users["address"] = trim(htmlspecialchars($_POST["address"]));
    $users["contactNumber"] = trim(htmlspecialchars($_POST["contactNumber"]));
    $users["gpa"] = trim(htmlspecialchars($_POST["gpa"]));
    $users["familyIncome"] = trim(htmlspecialchars($_POST["familyIncome"]));
    $users["school"] = trim(htmlspecialchars($_POST["school"]));
    $users["course"] = trim(htmlspecialchars($_POST["course"]));
    $users["yearLevel"] = trim(htmlspecialchars($_POST["yearLevel"]));

    if (empty($users["firstName"])) {
        $errors["firstName"] = "First name is required";
    }

    if (empty($users["lastName"])) {
        $errors["lastName"] = "Last name is required";
    }

    if (empty($users["middleName"])) {
        $errors["middleName"] = "Middle name is required";
    }

    if (empty($users["birthdate"])) {
        $errors["birthdate"] = "Birthdate is required";
    }

    if (empty($users["address"])) {
        $errors["address"] = "Address is required";
    }

    if (empty($users["contactNumber"])) {
        $errors["contactNumber"] = "Contact number is required";
    } elseif (!preg_match('/^[0-9]+$/', $users["contactNumber"])) {
        $errors["contactNumber"] = "Digits only (0-9)";
    }

    if (empty($users["gpa"])) {
        $errors["gpa"] = "GPA is required";
    }

    if (empty($users["familyIncome"])) {
        $errors["familyIncome"] = "Family income is required";
    }

    if (empty($users["school"])) {
        $errors["school"] = "School name is required";
    }

    if (empty($users["course"])) {
        $errors["course"] = "Course is required";
    }

    if (empty($users["yearLevel"])) {
        $errors["yearLevel"] = "Year level is required";
    }

    if (empty($errors)) {
        $userObj->firstName = $users["firstName"];
        $userObj->lastName = $users["lastName"];
        $userObj->middleName = $users["middleName"];
        $userObj->birthdate = $users["birthdate"];
        $userObj->address = $users["address"];
        $userObj->contactNumber = $users["contactNumber"];
        $userObj->gpa = $users["gpa"];
        $userObj->familyIncome = $users["familyIncome"];
        $userObj->school = $users["school"];
        $userObj->course = $users["course"];
        $userObj->yearLevel = $users["yearLevel"];

        $profile_id = $userObj->addProfile();

        if ($profile_id) {
            header("Location: usernamepass.php?profile_id=" . $profile_id);
            exit();
        } else {
            echo "<script>alert('Error saving profile. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="auth">
    <form action="" method="post" class="form-grid">  
        <h1>Register</h1>
        <label>Fields with <span>*</span> are required</label>

        <label for="firstName">First Name <span>*</span></label>
        <input type="text" name="firstName" id="firstName" value="<?= htmlspecialchars($_POST["firstName"] ?? "") ?>">
        <p class="error"><?= $errors["firstName"] ?? "" ?></p>

        <label for="lastName">Last Name <span>*</span></label>
        <input type="text" name="lastName" id="lastName" value="<?= htmlspecialchars($_POST["lastName"] ?? "") ?>">
        <p class="error"><?= $errors["lastName"] ?? "" ?></p>

        <label for="middleName">Middle Name <span>*</span></label>
        <input type="text" name="middleName" id="middleName" value="<?= htmlspecialchars($_POST["middleName"] ?? "") ?>">
        <p class="error"><?= $errors["middleName"] ?? "" ?></p>

        <label for="birthdate">Birthdate <span>*</span></label>
        <input type="date" name="birthdate" id="birthdate" value="<?= htmlspecialchars($_POST["birthdate"] ?? "") ?>">
        <p class="error"><?= $errors["birthdate"] ?? "" ?></p>

        <label for="address">Address <span>*</span></label>
        <input type="text" name="address" id="address" value="<?= htmlspecialchars($_POST["address"] ?? "") ?>">
        <p class="error"><?= $errors["address"] ?? "" ?></p>

        <label for="contactNumber">Contact Number <span>*</span></label>
        <input type="text" name="contactNumber" id="contactNumber" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="<?= htmlspecialchars($_POST["contactNumber"] ?? "") ?>">
        <p class="error"><?= $errors["contactNumber"] ?? "" ?></p>

        <label for="gpa">GPA <span>*</span></label>
        <input type="number" step="0.01" name="gpa" id="gpa" value="<?= htmlspecialchars($_POST["gpa"] ?? "") ?>">
        <p class="error"><?= $errors["gpa"] ?? "" ?></p>

        <label for="familyIncome">Family Income <span>*</span></label>
        <input type="number" step="0.01" name="familyIncome" id="familyIncome" value="<?= htmlspecialchars($_POST["familyIncome"] ?? "") ?>">
        <p class="error"><?= $errors["familyIncome"] ?? "" ?></p>

        <label for="school">School <span>*</span></label>
        <input type="text" name="school" id="school" value="<?= htmlspecialchars($_POST["school"] ?? "") ?>">
        <p class="error"><?= $errors["school"] ?? "" ?></p>

        <label for="course">Course <span>*</span></label>
        <input type="text" name="course" id="course" value="<?= htmlspecialchars($_POST["course"] ?? "") ?>">
        <p class="error"><?= $errors["course"] ?? "" ?></p>

        <label for="yearLevel">Year Level <span>*</span></label>
        <input type="number" name="yearLevel" id="yearLevel" value="<?= htmlspecialchars($_POST["yearLevel"] ?? "") ?>">
        <p class="error"><?= $errors["yearLevel"] ?? "" ?></p>

        <div class="form-actions">
            <input type="submit" value="Register" class="btn btn-success">
            <a href="login.php" class="btn btn-outline">Already have an account?</a>
        </div>
    </form>
</body>
</html>
