<?php
	/*Esta pagina se ha creado con el fin de que el
	directorio no pueda ser visto por los usuarios*/
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']=="si"){//el usuario es el profesor
				header('Refresh:0; url=../profesor/ver_codigo.php');
			}
			else header('Refresh:0; url=codigos/ver_codigos.php');
		
	}
	else header('Refresh:0; url=entrar.php');//no existe una sesion

?>