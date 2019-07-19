<?php
	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../../usuarios/entrar.php');


	$nombrep=$_POST['nombre'];
	$asignaturap=$_POST['asignatura'];
	$grulo=$nombrep.$asignaturap;
	
	if (isset($_POST['nalum'])){//se mando la orden de eliminar un alumno de un grupo
		$login= new SimpleXMLElement('../../recursos/xml/login.xml', 0, true);//se abre el archivo
			foreach ($login as $usuario)
			{
				if($usuario->nombre==$_POST['nalum'])//encontramos al alumno a borrar
				{
					$usuario->grupo="";
				}
			}
		$login->asXML('../../recursos/xml/login.xml');//se guarda el archivo
	}
	
	if (isset($_POST['nalums'])){//se mando la orden de agregar un alumno a un grupo
		$login= new SimpleXMLElement('../../recursos/xml/login.xml', 0, true);//se abre el archivo
			foreach ($login as $usuario)
			{
				if($usuario->nombre==$_POST['nalums'])//encontramos al alumno a borrar
				{
					//caso 1 el grupo es igual a ""
					if($usuario->grupo=="")
					{
						$usuario->grupo=$grulo;
					}
					//caso 2 el nodo grupo no existe
					else if(!isset($usuario->grupo))
					{
						$usuario->addChild('grupo', $grulo);
					}
				}
			}
		$login->asXML('../../recursos/xml/login.xml');//se guarda el archivo
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Grupo <?=$nombrep?></title>
		
		<link href="../../recursos/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="../../recursos/js/jquery.min.js"></script>
		<script src="../../recursos/js/jquery-ui.js"></script>
		
		<!-- Bootstrap core CSS -->
		<link href="../../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">
		
		<!-- Bootstrap theme -->
		<link href="../../recursos/bs/dist/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../../recursos/css/theme.css" rel="stylesheet">
		
		<!-- Custom styles for this template -->
		<link href="../../recursos/css/grid.css" rel="stylesheet">
		
		<!--script para mostrar/ocultar tabla de alumnos no inscritos-->
		<script>
			function mostrarOcultarTablas(id){
				var mostrado=0;
				var elem = document.getElementById(id);
				if(elem.style.display=='block')mostrado=1;
					elem.style.display='none';
				if(mostrado!=1)elem.style.display='block';
			}
		</script>
		
	</head>
	<body>
	
		
		<!-- Fixed navbar -->
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
            <li><a href="../codigos.php">Ver codigos</a></li>
            <li><a href="../crear_codigo/lenguaje.php">Escribir codigo</a></li>
			<li class="active"><a href="ver_grupos.php">Grupos</a></li>
            <li><a href="../../usuarios/salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
		<!--Columnas con contenido-->
		<div class="container" ><!--inicia contenedor-->
		
		<!--Lista de grupos-->
		<h3 align="left">Grupo: <?=$nombrep?> <?=$asignaturap?></h3>
		<?php
			/*Generando la informacion para cada uno de los nodos en la lista de grupos*/
			$grupos= new SimpleXMLElement('../../recursos/xml/grupos.xml', 0, true);//se abre el archivo
			
			//generamos la lista de grupos a usar
			
			foreach ($grupos as $grupo)
			{
				$nombre=$grupo->nombre;
				$asignatura=$grupo->asignatura;
				
				
				if($nombre==$nombrep && $asignatura==$asignaturap)
				{
						$login= new SimpleXMLElement('../../recursos/xml/login.xml', 0, true);//se abre el archivo
						foreach ($login as $usuario)
						{
							if($usuario->grupo==$grulo)
							{
								$alusi[]=$usuario->nombre;
							}
							else if($usuario->admin!="si" && !isset($usuario->grupo))/*Solo se permite un grupo por usuario*/
							{
								$aluno[]=$usuario->nombre;
							}
							else if($usuario->admin!="si" && $usuario->grupo=="")/*Condicion grupo ==""*/
							{
								$aluno[]=$usuario->nombre;
							}
						}
						
				}
				
			}
			
			/*Ya sabemos que alumnos estan inscritos en este grupo y cuales no, solo queda mostrarlos.
			Pero antes los ordenaremos alfabeticamente para un mejor control*/
			
			function callback($name1,$name2){//esta funcion evita que al ordenar los caracteres con asentos esten hasta el final
				$patterns = array(
					'a' => '(á|à|â|ä|Á|À|Â|Ä)',
					'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
					'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
					'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
					'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
				);          
				$name1 = preg_replace(array_values($patterns), array_keys($patterns), $name1);
				$name2 = preg_replace(array_values($patterns), array_keys($patterns), $name2);          
				return strcasecmp($name1, $name2);
			}
			
			
			?>
			
			<!--Mostrando alumnos inscritos-->
			<div class="row"><div class="col-md-8">
				<div class="row" style="padding-left: 50px; padding-bottom: 20px;">
				<h4>Alumnos inscritos:</h4></br>
					<table cellpadding="10px">
						<thead>
						<tr>
							<th>#</th>
							<th> Nombre</th>
							<th>Eliminar</th>
						</tr>
						</thead>
						<tbody align="center">
						<?php
						
						if(isset($alusi)){
							uasort($alusi,"callback");//alumnos inscritos en el grupo
						
						for ($i=0; $i<count($alusi); $i++){
							$n=1+$i;
							echo '<tr>';
							echo '<td>'.$n.'</td>';
							echo '<td>'.$alusi[$i].'</td>';
							echo '<td>';
								echo '<form action="grupo.php" method="post" name="borrar">';
								echo '<input name="nalum" type="hidden" value="'.$alusi[$i].'">';
								echo '<input name="nombre" type="hidden" value="'.$nombrep.'">';
								echo '<input name="asignatura" type="hidden" value="'.$asignaturap.'">';
								echo '<button type="submit" name="borrar" class="btn btn-danger btn-xs">&times;</button>';//boton para borrar un alumno
								echo '</form>';
							echo '</td>';
							echo '</tr>';
						}
						}
							else echo '<tr><td>No hay alumnos inscritos</td></tr>';
						?>
						</tbody>
						
					</table>
			</div></div></div>
			
			<!--Agregar inscribir alumno-->
			
			<button type="button" class="btn btn-primary" onclick="mostrarOcultarTablas('nois')">Agregar alumnos</button>
				</br>
					<table cellpadding="10px" id="nois"  style="display:none">
						<thead>
						<tr>
							<th> Nombre</th>
							<th>Agregar</th>
						</tr>
						</thead>
						<tbody align="center">
						<?php
						if(isset($aluno)){
						uasort($aluno,"callback");//alumnos no inscritos en el grupo
						for ($i=0; $i<count($aluno); $i++){
							echo '<tr>';
							echo '<td>'.$aluno[$i].'</td>';
							echo '<td>';
								echo '<form action="grupo.php" method="post" name="agregar">';
								echo '<input name="nalums" type="hidden" value="'.$aluno[$i].'">';
								echo '<input name="nombre" type="hidden" value="'.$nombrep.'">';
								echo '<input name="asignatura" type="hidden" value="'.$asignaturap.'">';
								echo '<button type="submit" name="agregar" class="btn btn-success btn-xs">Agregar</button>';//boton para borrar un alumno
								echo '</form>';
							echo '</td>';
							echo '</tr>';
						} 
						}
						else echo '<tr><td>No hay alumnos disponibles para inscribir</td></tr>';
						?>
						</tbody>
						
					</table>
		</div><!--Final container-->
	
	
	</body>
</html>