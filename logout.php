<?php
require_once 'includes/auth.php';

session_destroy();
header('Location: login.php?success=You have been logged out successfully.');
exit();
?>
