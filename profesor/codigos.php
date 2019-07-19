<?php

	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../usuarios/entrar.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Codigos</title>
		
		<!-- Bootstrap core CSS -->
		<link href="../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../recursos/css/grid.css" rel="stylesheet">
		
		<!-- Bootstrap theme -->
		<link href="../recursos/bs/dist/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../recursos/css/theme.css" rel="stylesheet">
		
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
            <li class="active"><a href="#">Ver codigos</a></li>
            <li><a href="crear_codigo/lenguaje.php">Escribir codigo</a></li>
			<li><a href="grupos/ver_grupos.php">Grupos</a></li>
            <li><a href="../usuarios/salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
	
		<!--Columnas con contenido-->
		<div class="container" align="center"><!--inicia contenedor-->
		<h2 align="left">Listado de codigos:</h2>
		<?php
			/*Generando la informacion para cada uno de los nodos en la lista de codigos*/
			$codigos= new SimpleXMLElement('../recursos/xml/codigos.xml', 0, true);//se abre el archivo
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
				echo '<h3 align="left">Codigo: '.$nombre.'</h3>';//nombre del codigo
				echo '<div class="row" ><div class="col-md-4">';//inicia 1ra subreja
					echo '<form action="ver_codigo.php" method="post" name="ver">';
					echo '<input name="nombre" type="hidden" value="'.$nombre.'">';
					echo '<input name="lenguaje" type="hidden" value="'.$lenguaje.'">';
					echo '<input name="brush" type="hidden" value="'.$brush.'">';
					echo '<button type="submit" name="ver" class="btn btn-primary">Ver</button>';//boton para ver un archivo
					echo '</form>';
				echo '</div>';//termina 1ra subreja
				echo '<div class="col-md-4">';//inicia 2da subreja
					echo '<form action="crear_codigo/modificar.php" method="post" name="modificar">';
					echo '<input name="nombre" type="hidden" value="'.$nombre.'">';
					echo '<input name="lenguaje" type="hidden" value="'.$lenguaje.'">';
					echo '<input name="brush" type="hidden" value="'.$brush.'">';
					echo '<input name="num_filas" type="hidden" value="'.$nfil.'">';
					echo '<input name="num_col" type="hidden" value="'.$ncol.'">';
					echo '<input name="lineas" type="hidden" value="'.$lineas.'">';
					echo '<button type="submit" name="modificar" class="btn btn-info">Modificar</button>';//boton para modificar un archivo
					echo '</form>';
				echo '</div>';//termina 2da subreja
				echo '<div class="col-md-4">';//inicia 3ra subreja
					echo '<form action="crear_codigo/borrar_ar.php" method="post" name="borrar">';
					echo '<input name="nombre" type="hidden" value="'.$nombre.'">';
					echo '<button type="submit" name="borrar" class="btn btn-danger">Borrar</button>';//boton para borrar un archivo
					echo '</form>';
				echo '</div>';//termina 3ra subreja
				echo '</div></div></div>';//termina reja grande
			
			
			}
			?>
	</div><!--Final container-->
	</body>
</html>
