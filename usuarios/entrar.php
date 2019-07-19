<?php
	if(isset($_GET['error']))
	{
		if($_GET['error']==1)
		{
			echo "<script language='javascript'>"; 
			echo "alert('Error al entrar, por favor verifique sus datos o registrese.')"; 
			echo "</script>";
			header('Refresh:0; url=entrar.php');
		}
		if($_GET['error']==2)
		{
			echo "<script language='javascript'>"; 
			echo "alert('Formulario vacio')"; 
			echo "</script>";
			header('Refresh:0; url=entrar.php');
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Entrar</title>
		
		<!-- Bootstrap core CSS -->
    <link href="../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../recursos/css/signin.css" rel="stylesheet">
	
	</head>
	<body>
		<div class="container">

      <form class="form-signin" method="post" name="entrar1" id="entrar1" action="acceso.php">
        <h2 class="form-signin-heading">Entrar</h2>
        <input type="text" class="form-control" placeholder="Nombre" name="enom" required autofocus>
        <input type="password" class="form-control" placeholder="Contraseña" name="econ"required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="entrar" value="entrar">Entrar</button>
      </form>
		<a href="registrarse.php">Registrarse</a>
    </div> <!-- /container -->
		
		
	</body>
</html>