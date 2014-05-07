<?php
session_start();
session_destroy();
header("location:index.php"); //to redirect back to "index.php" after logging out
exit();
?>
<!-- <meta http-equiv="refresh" content="0; url=index.php"> -->
