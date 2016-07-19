<?php
session_start();
unset($_SESSION['user']);
session_destroy();

header("Location: index.php");
echo "You have been logged out, redirecting to Admin Dashboard login page";
exit;
?>
