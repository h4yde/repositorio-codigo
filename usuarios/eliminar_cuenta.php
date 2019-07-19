<?php
	$errores=array();
	if(isset($_POST['snuff']))
	{
		$usrval=0;
		$nusr=0;
		
		if(file_exists('login.xml'))
		{
		
			$login= new SimpleXMLElement('login.xml', 0, true);
			
			foreach ($login as $usuario)
			{
				if($usuario->nombre!=$_POST['snom']) $nusr=$nusr+1;
				else break;
			}
			foreach ($login as $usuario)
			{
				if(($usuario->nombre==$_POST['snom']) && ($usuario->contra==$_POST['scon']))
				{
					echo 'La cuenta se eliminara';
					$usrval=1;
					$login->usuario[$nusr] = null;
				}
			}
			if($usrval==0) echo 'Error: usuario o/y contraseña no valido.';
		}
		else echo 'Error: no se encuentran los archivos de usuarios';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Eliminar cuenta</title>
	</head>
	<body>
		<h1>Eliminar cuenta</h1>
		<form method="post" action="">
			<p>Nombre:<input type="text" name="snom" size="20" /></p>
			<p>Contraseña:<input type="password" name="scon" size="20" /></p>
			<p><input type="submit" name="snuff" value="Eliminar cuenta" /></p>
		</form>
		<a href="entrar.php">Iniciar Sesión</a>
	</body>
</html>