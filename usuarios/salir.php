<?php
	session_start();
	session_destroy();
	if (isset($_SESSION['prof'])){ 
		header('Refresh:0; url=salir.php');
	}else header('Refresh:0; url=entrar.php');
?>