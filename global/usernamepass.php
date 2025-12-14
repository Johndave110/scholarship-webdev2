<?php
require_once "../classes/Users.php";

$userObj = new Users();
$errors = [];

$profile_id = $_GET['profile_id'] ?? null;

if (!$profile_id) {
    die("Profile ID not found. Please register first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(htmlspecialchars($_POST["username"]));
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirm_password"]);

    if (empty($username)) {
        $errors['username'] = "Username is required";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long.";
    }

    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $userObj->username = $username;
        $userObj->password = $password; // ✅ no hashing here
        $userObj->role = "student";
        $userObj->profile_id = $profile_id;

        $result = $userObj->addUser();

        if ($result === true) {
            echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
            exit();
        } elseif ($result === 'duplicate') {
            $errors['username'] = "Username already taken.";
        } else {
            echo "Error creating account.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Username & Password</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="auth">
    <h1>Create Account</h1>
    <form action="" method="post" onsubmit="return validatePasswords();" class="form-standard">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        <p class="error"><?= $errors['username'] ?? '' ?></p>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" onkeyup="checkStrength()">
        <p class="error"><?= $errors['password'] ?? '' ?></p>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" onkeyup="checkMatch()">
        <p id="match-message"></p>
        <p class="error"><?= $errors['confirm_password'] ?? '' ?></p>

        <input type="hidden" name="role" value="student">

        <input type="submit" value="Create Account" class="btn-primary">
    </form>

    <script>
        // ✅ Password Match Checker
        function checkMatch() {
            const pass = document.getElementById("password").value;
            const confirm = document.getElementById("confirm_password").value;
            const message = document.getElementById("match-message");

            if (confirm.length === 0) {
                message.textContent = "";
                return;
            }

            if (pass === confirm) {
                message.style.color = "green";
                message.textContent = "✅ Passwords match";
            } else {
                message.style.color = "red";
                message.textContent = "❌ Passwords do not match";
            }
        }

        // ✅ Optional: Password Strength Indicator
        function checkStrength() {
            const pass = document.getElementById("password").value;
            const message = document.getElementById("match-message");

            if (pass.length < 8) {
                message.style.color = "orange";
                message.textContent = "⚠️ Password should be at least 8 characters";
            } else {
                message.textContent = "";
            }
        }

        // ✅ Prevent submission if passwords don't match
        function validatePasswords() {
            const pass = document.getElementById("password").value;
            const confirm = document.getElementById("confirm_password").value;

            if (pass !== confirm) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
