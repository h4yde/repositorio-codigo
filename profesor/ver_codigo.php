<?php
	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../usuarios/entrar.php');
	
	//obtencion de variables a usar
	$lenguaje=$_POST['lenguaje'];
	$brush=$_POST['brush'];
	$nombre=$_POST['nombre'];
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Ver Codigo: <?=$nombre.".".$lenguaje?></title>
		
		<!-- Bootstrap core CSS -->
		<link href="../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">
		
		<!-- Bootstrap theme -->
		<link href="../recursos/bs/dist/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../recursos/css/theme.css" rel="stylesheet">
	
		<!--Scripts para el resaltado-->
		<script type="text/javascript" src="../recursos/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
		<script type="text/javascript" src="../recursos/syntaxhighlighter_3.0.83/scripts/<?=$brush?>.js"></script>
		<link type="text/css" rel="stylesheet" href="../recursos/syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
		<script type="text/javascript">SyntaxHighlighter.all();</script>
		
		<script type="text/javascript">
			function guardar_calif(usuario)
			{
				//busca el campo de la puntuacion
				var puntu = document.getElementById("punt_"+usuario);
				
				//Validamos que exista una calificacion
				if(puntu.options[puntu.selectedIndex].value=="")
				{
					alert("Calificacion no valida.");
					return;
				}
				
				//verifica si el checkbox de favorito esta marcado
				if(document.getElementsByName("fav_"+usuario)[0].checked)
				{
					var fav="si";
				}
				else
				{
					var fav="no";
				}
				
				//confirmando los datos
				cfm=confirm("Se guardaran los siguientes datos:\n \nUsuario: "+usuario+"\nPuntuacion: "+puntu.options[puntu.selectedIndex].value+"\nFavoritos: "+fav);
				
				if(cfm==true)
				{
					window.open('guardar_cal.php?punt='+puntu.options[puntu.selectedIndex].value+'&fav='+fav+'&usuario='+usuario+'&nombre=<?=$nombre?>'+'&lenguaje=<?=$lenguaje?>');
					document.getElementsByName("guar_"+usuario)[0].disabled=true;
					//location.reload();
				}
			}
			  
		</script>
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
            <li class="active"><a href="codigos.php">Ver codigos</a></li>
            <li><a href="crear_codigo/lenguaje.php">Escribir codigo</a></li>
			<li><a href="grupos/ver_grupos.php">Grupos</a></li>
            <li><a href="../usuarios/salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
		
		
		<div class="container">
		<!--Acciones con el codigo
		<div align="center">
			<button name="modificar" class="btn btn-info" onclick="crear_codigo/modificar.php">Modificar</button>
			<button name="cancelar" class="btn btn-danger" onclick="codigos.php">Cancelar</button>
		</div>-->
		
		<h3> <?=$nombre?>.<?=$lenguaje?></h3>
		
		<!--Visualizacion del codigo-->
		<pre class="brush: <?=$lenguaje?>"; style="max-width: 400px; margin: 0 auto 10px;"><?php include('../recursos/codigos/' . $nombre . '.txt'); ?></pre>

		</br></br>
		<!--Comentarios de los usuarios-->
		<?php
			$lol="'";
			/*Generacion de cada uno de los comentarios contenidos en el correspondiente xml*/
			$com= new SimpleXMLElement('../recursos/xml/comentarios/'.$nombre.'.xml', 0, true);//se abre el archivo
			
			//generamos la tabla con los datos de cada comentario
			foreach ($com as $coment)
			{
				$usuario=$coment->nombre;
				$calif=$coment->calificacion;
				$desta=$coment->desta;
				$texto=$coment->texto;
				
				
				//alumno no calificado
				if($calif==6)
					{
			echo '<table>';
			echo '<tr>';
			echo '<td colspan="3">Usuario: ' .$usuario . '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="3">' . $texto . '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>';
					echo 'Puntuacion  ';
					echo '<select name="puntuacion" id="punt_'.$usuario.'" >';
						echo '<option select value>-</option>';
						echo '<option value="1">1</option>';
						echo '<option value="2">2</option>';
						echo '<option value="3">3</option>';
						echo '<option value="4">4</option>';
						echo '<option value="5">5</option>';
					echo '</select>';
				echo '</td>';
				echo '<td>';
					echo 'Favorito <input type="checkbox" name="fav_'.$usuario.'" value="si"';
				echo '</td>';
				echo '<td>';
					echo '<button name="guar_'.$usuario.'" onclick="guardar_calif('.$lol.$usuario.$lol.')" class="btn btn-primary btn-sm">Guardar</button>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</br></br>';
		}
		
		//Alumno Calificado
		else {
			if($desta=="si")
		{
			echo '<font color="#A9F5A9"">Comentario destacado:</font>';
			echo '<table  border="2" bordercolor="#A9F5A9">';
		}
		else echo '<table   border="1" bordercolor="#FFFFFF">';
			echo '<tr>';
			echo '<td>Usuario: ' .$usuario . '</td>';
				echo '<td>Puntuacion: ' .$calif . '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="3">' . $texto . '</td>';
			echo '</tr>';
			
			/*Modificar calificacion
			echo '<tr>';
				echo '<td>';
					echo 'Puntuacion  ';
					echo '<select name="puntuacion" id="punt_'.$usuario.'" >';
						echo '<option select value>-</option>';
						echo '<option value="1">1</option>';
						echo '<option value="2">2</option>';
						echo '<option value="3">3</option>';
						echo '<option value="4">4</option>';
						echo '<option value="5">5</option>';
					echo '</select>';
				echo '</td>';
				echo '<td>';
					echo 'Favorito <input type="checkbox" name="fav_'.$usuario.'" value="si"';
				echo '</td>';
				echo '<td>';
					echo '<button name="guar_'.$usuario.'" onclick="guardar_calif('.$lol.$usuario.$lol.')" class="btn btn-primary btn-sm">Modificar</button>';
				echo '</td>';
				*/
				
			echo '</tr>';
		echo '</table></br></br>';
		}}
		?>
		
		
		
		</div><!--final container-->
	</body>
</html>
