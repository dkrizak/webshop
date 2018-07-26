<?php
	session_start();
	session_unset();
	session_destroy();
	header("Location: index.php?msg=Uspješno_ste_se_odjavili.");
?>