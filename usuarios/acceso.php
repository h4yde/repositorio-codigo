<?php
	if(isset($_POST['entrar']))
	{
		$nombre=$_POST['enom'];
		$contra=$_POST['econ'];
		$usrval=1;
		
		if(file_exists('../recursos/xml/login.xml'))
		{
			$xml= new SimpleXMLElement('../recursos/xml/login.xml', 0, true);
			
			foreach ($xml as $usuario)
			{
				if(($usuario->nombre==$_POST['enom']) && ($usuario->contra==$_POST['econ']))
				{
					$usrval=0;
					session_start();//se inicia la sesion
					$_SESSION['enom'] = $nombre;//creamos variable de sesion con el nombre del usuario
					
					if(isset($usuario->admin)){
						$_SESSION['prof'] = 'si';//el usuario no es el profesor
						header('Refresh:0; url=../profesor/codigos.php');//redireccionamos a la pagina de codigos alumno
					}
					else{
					$_SESSION['prof'] = 'no';//el usuario no es el profesor
					header('Refresh:0; url=codigos/ver_codigos.php');//redireccionamos a la pagina de codigos alumno
					}
				}
			}
			
			if($usrval==1)
			{
				header('Refresh:0; url=entrar.php?error=1');
			}
		}
	}
	else	header('Refresh:0; url=entrar.php?error=2');
?>
