<?php
session_start();
require_once "../classes/Users.php";
require_once "../classes/Profile.php"; // Add this

$userObj = new Users();
$profileObj = new Profile(); // Add this

$errors = [];
$username = "";
$password = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim(htmlspecialchars($_POST["username"]));
    $password = trim(htmlspecialchars($_POST["password"]));

    if(empty($username)){
        $errors['username'] = "Username is required";
    }

    if(empty($password)){
        $errors['password'] = "Password is required";
    }

    if(empty($errors)){
        $user = $userObj->login($username, $password);
        if($user){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            if($user['role'] === 'student'){
                // ✅ Fetch the student's profile to get GPA
                $profile = $profileObj->viewProfile($user['user_id']);
                $_SESSION['gpa'] = isset($profile['gpa']) ? floatval($profile['gpa']) : 0.0;

                header("Location: ../student/studash.php");
                exit();
            } elseif($user['role'] === 'admin'){
                header("Location: ../admin/dashboard.php");
                exit();
            }
        } else {
            $errors['login'] = "Invalid username or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="auth"> 
    <form action="" method="post" class="form-standard">
        <h1>Login</h1>

        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($username) ?>">
        <p class="error"><?= $errors['username'] ?? '' ?></p>

        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <p class="error"><?= $errors['password'] ?? '' ?></p>

        <p class="error"><?= $errors['login'] ?? '' ?></p>

        <div class="form-actions">
            <input type="submit" value="Login" class="btn btn-primary">
            <a href="Register.php" class="btn btn-outline">Register</a>
        </div>
    </form>
</body>
</html>
