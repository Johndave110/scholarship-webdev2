<?php
// Landing page relocated to /global/index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Scholarship Portal</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="nav-logo">
                <img src="https://via.placeholder.com/60" alt="Logo" />
                <span>Scholarship Portal</span>
            </div>
            <input type="checkbox" id="menu-toggle" />
            <label class="menu-icon" for="menu-toggle">&#9776;</label>
            <div class="nav-links">
                <a href="#top">Home</a>
                <a href="#features">Features</a>
                <a href="#how">How It Works</a>
                <a href="#about">About</a>
            </div>
            <div class="profile">
                <a class="btn btn-outline" href="login.php">Login</a>
                <a class="btn btn-success" href="Register.php">Register</a>
            </div>
        </div>
    </nav>

    <header id="top" class="hero">
        <div class="hero-inner">
            <h1>Find, Apply & Track Scholarships Easily</h1>
            <p>Unified platform for students and administrators. Browse opportunities, submit applications, and manage awards with a consistent experience.</p>
            <div class="actions">
                <a href="Register.php" class="btn btn-success">Get Started</a>
                <a href="login.php" class="btn btn-outline">Login</a>
            </div>
        </div>
    </header>

    <main class="container mt-nav">
        <section id="features" class="feature-grid">
            <div class="feature">
                <h3>Browse Scholarships</h3>
                <p>Search and filter available scholarships with clear criteria and deadlines.</p>
            </div>
            <div class="feature">
                <h3>Smart Applications</h3>
                <p>Upload required documents and track submission status in real time.</p>
            </div>
            <div class="feature">
                <h3>Progress Tracking</h3>
                <p>Monitor each application stage: submitted, under review, approved or declined.</p>
            </div>
            <div class="feature">
                <h3>Admin Tools</h3>
                <p>Centralized dashboard for reviewing, approving, and managing scholarship slots.</p>
            </div>
        </section>

        <section id="how" class="section-accent">
            <div class="container">
                <h2>How It Works</h2>
                <p>Students create a profile, browse scholarships, apply with required documents, and receive notifications. Administrators configure opportunities, review submissions, and approve awards — all from one interface.</p>
                <a href="Register.php" class="btn btn-outline">Create Your Account</a>
            </div>
        </section>
    </main>

    <section id="about" class="container">
        <h2>About Scholarship Portal</h2>
        <p>This portal was created to simplify scholarship discovery and management for students and administrators. It centralizes opportunities, streamlines applications, and improves transparency during the review process.</p>
    </section>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Scholarship Portal. All rights reserved.</p>
        <p><a href="#top">Back to top</a></p>
    </footer>
</body>
</html>