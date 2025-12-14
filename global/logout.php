<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to global landing page
header("Location: /webdev-2-Scholarship/global/index.php");
exit();