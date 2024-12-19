<?php
session_start();
session_unset(); // hapus session
session_destroy(); // hancurkan session

header("Location: index.php");
exit();
?>
