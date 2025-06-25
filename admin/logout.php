<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\logout.php
session_start();
session_unset();
session_destroy();
header("Location: ../login.php");
exit();
?>