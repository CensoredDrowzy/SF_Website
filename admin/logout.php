<?php
session_start();
session_destroy();
header("Location: new_login.php");
exit();
?>