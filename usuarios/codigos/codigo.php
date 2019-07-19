<?php
	//codigo pagina de alumno
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
		
			$usuario=$_SESSION['enom'];//variable con nombre del usuario
		
	}else header('Refresh:0; url=../entrar.php');
	
	//obtencion de variables a usar
	if(isset($_POST['lenguaje']))
	{
		$lenguaje=$_POST['lenguaje'];
		$nombre=$_POST['nombre'];
		$brush=$_POST['brush'];
	}
	
	if(isset($_GET['lenguaje']))
	{
		$lenguaje=$_GET['lenguaje'];
		$nombre=$_GET['nombre'];
		$brush=$_GET['brush'];
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Codigo <?=$nombre?></title>
	
		<!--Scripts para el resaltado-->
		<script type="text/javascript" src="../../recursos/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
		<script type="text/javascript" src="../../recursos/syntaxhighlighter_3.0.83/scripts/<?=$brush?>.js"></script>
		<link type="text/css" rel="stylesheet" href="../../recursos/syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
		<script type="text/javascript">SyntaxHighlighter.all();</script>
		
		<!-- Bootstrap core CSS -->
		<link href="../../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../../recursos/css/grid.css" rel="stylesheet">
		
		<!-- Bootstrap theme -->
		<link href="../../recursos/bs/dist/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../../recursos/css/theme.css" rel="stylesheet">
		
	</head>

	<body>
		
		<!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Proyecto TW</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="ver_codigos.php">Ver codigos</a></li>
            <li><a href="../salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
		
		<div class="container">
		
		<h3><?=$nombre?>.<?=$lenguaje?></h3>
		<!--Visualizacion del codigo-->
		<pre class="brush: <?=$lenguaje?>;"><?php include('../../recursos/codigos/' . $nombre . '.txt'); ?></pre>
		</br></br>
		<!--Comentar codigo-->
		<form method="post" action="comentar.php" id="coment" name="coment" class="form-horizontal" role="form">
		
			<div class="form-group">
				<label for="comentario" class="control-label">Usuario: <?=$usuario?></label></br>
				<textarea name="comentario" class="input-medium" placeholder="Escribe aquí tu comentario..." rows="5" cols="120"></textarea>
			</div>
			<input type="hidden" name="usuario" value="<?=$usuario?>"/>
			<input type="hidden" name="nombre" value="<?=$nombre?>"/>
			<input type="hidden" name="lenguaje" value="<?=$lenguaje?>"/>
			<input type="hidden" name="brush" value="<?=$brush?>"/>
			<input type="submit" name="comentar" value="Enviar" class="btn btn-success" />
		</form>
		
		</br></br>
		
		<!--Comentarios de los usuarios-->
		<?php
			$lol="'";
			/*Generacion de cada uno de los comentarios contenidos en el correspondiente xml*/
			$com= new SimpleXMLElement('../../recursos/xml/comentarios/'.$nombre.'.xml', 0, true);//se abre el archivo
			
			//generamos la tabla con los datos de cada comentario
			foreach ($com as $coment)
			{
				$usuario=$coment->nombre;
				$calif=$coment->calificacion;
				$desta=$coment->desta;
				$texto=$coment->texto;
				
			
		if($desta=="si")
		{
			echo '<font color="#A9F5A9"">Comentario destacado:</font>';
			echo '<table width=700  border="2" bordercolor="#A9F5A9">';
		}
		else echo '<table   border="1" width=700 bordercolor="#FFFFFF">';
			echo '<tr>';
			echo '<td>Usuario: ' .$usuario . '</td>';
				if($calif!=6) echo '<td>Puntuacion: ' .$calif . '</td>';
				else echo '<td>Sin puntuacion</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="3">' . $texto . '</td>';
			echo '</tr>';
		echo '</table></br></br>';
		}
		?>
		
		</div>
		
	</body>
</html>
