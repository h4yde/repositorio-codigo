<?php

	//codigo pagina de alumno
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
		
			$usuario=$_SESSION['enom'];//variable con nombre del usuario
		
	}else header('Refresh:0; url=../entrar.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Codigos</title>
		
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
	
	
		<!--Columnas con contenido-->
		<div class="container" align="center"><!--inicia contenedor-->
		<h2 align="left">Listado de codigos:</h2>
		<?php
			/*Generando la informacion para cada uno de los nodos en la lista de codigos*/
			$codigos= new SimpleXMLElement('../../recursos/xml/codigos.xml', 0, true);//se abre el archivo
			//generamos la lista de codigos a usar
	
			foreach ($codigos as $codigo)
			{
				$nombre=$codigo->nombre;
				$lenguaje=$codigo->lenguaje;
				$brush=$codigo->brush;
				$ncol=$codigo->ncol;
				$nfil=$codigo->nfil;
				$lineas=$codigo->lineas;

				echo '<div class="row"><div class="col-md-8">';//inicia reja grande
				echo '<h3>Codigo: '.$nombre.'</h3>';//nombre del codigo
				
					echo '<form action="codigo.php" method="post" name="ver">';
					echo '<input name="nombre" type="hidden" value="'.$nombre.'">';
					echo '<input name="lenguaje" type="hidden" value="'.$lenguaje.'">';
					echo '<input name="brush" type="hidden" value="'.$brush.'">';
						echo '<div style="max-width: 400px; margin: 0 auto 10px;">';//dandole tamaño al boton
							echo '<button type="submit" name="ver" class="btn btn-primary btn-block">Ver</button>';//boton para ver un archivo
						echo '</div>';
					echo '</form>';
				
				echo '</div></div>';//termina reja grande
			
			
			}
			?>
	</div><!--Final container-->
	</body>
</html>
