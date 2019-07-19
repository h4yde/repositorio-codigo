<?php
	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../../usuarios/entrar.php');

	if (isset($_POST['nombre'])){ //se envio un formulario y se recibio un nombre
		if (isset($_POST['asignatura'])){ //se envio un formulario
			/*Generando la informacion para cada uno de los nodos en la lista de grupos*/
			$grupos= new SimpleXMLElement('../../recursos/xml/grupos.xml', 0, true);//se abre el archivo
			//generamos la lista de grupos a usar
			
			$existe=0;
			
			foreach ($grupos as $grupo)
			{
				/*Como un el nombre de un grupo puede tener distintas asignaturas y una asignatura puede tener
				distintos grupos, pero un grupo no puede repetir la asignatura se crea este for, para verificar
				que se repitan los nodos grupo*/
				if($_POST['nombre']==$grupo->nombre && $_POST['asignatura']==$grupo->asignatura)
				{
					$existe=1;
				}
			}
			
			if($existe==0)//elgrupo no existe
			{
			/*Creamos un nuevo nodo para el grupo*/
				$grupo = $grupos->addChild('grupo');
					$grupo->addChild('nombre', $_POST['nombre']);
					$grupo->addChild('asignatura', $_POST['asignatura']);	
			
				$grupos->asXML('../../recursos/xml/grupos.xml');//se guarda el grupo
					
					echo "<script language='javascript'>"; 
					echo "alert('Se guardo el grupo.')"; 
					echo "</script>";
					
				header('Refresh:0; url=ver_grupos.php');
					
			}
			else //el grupo ya existe
			{
				echo "<script language='javascript'>"; 
				echo "alert('Error: El grupo ya existe. Ingrese otros datos.')"; 
				echo "</script>";
				
				header('Refresh:0; url=ver_grupos.php');
			}
		}
	}
	
	if (isset($_POST['bnombre'])){//se borrara un grupo
		if (isset($_POST['basignatura'])){
			$grulo=$_POST['bnombre'].$_POST['basignatura'];
			
			/*Primero quitamos de este grupo a los alumnos
			inscritos en el*/
			$login= new SimpleXMLElement('../../recursos/xml/login.xml', 0, true);//se abre el archivo
			foreach ($login as $usuario)
			{
				if($usuario->grupo==$grulo)//encontramos al alumno inscrito
				{
					$usuario->grupo="";//lo sacamos del grupo
				}
			}
			$login->asXML('../../recursos/xml/login.xml');//se guarda el archivo
			
			
			/*Ahora eliminamos el nodo de este grupo*/
			$doc = new DOMDocument;
			$numnodo=0;
			$doc->load('../../recursos/xml/grupos.xml');
			
			$grupoN= new SimpleXMLElement('../../recursos/xml/grupos.xml', 0, true);//se abre el archivo
	
			foreach ($grupoN as $grupo)
			{
				if($grupo->nombre!=$_POST['bnombre']) $numnodo=$numnodo+1;
				else break;
			}
	
	
		/*Borrar nodo con dom*/
		$grupos = $doc->documentElement;

		// recuperamos el nodo y lo borramos
		$grupo = $grupos->getElementsByTagName('grupo')->item($numnodo);
		$borrado = $grupos->removeChild($grupo);

		$doc->save('../../recursos/xml/grupos.xml');
		
		header('Refresh:0; url=ver_grupos.php');//redireccionamos para evitar problemas
		}
	}
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Grupos</title>
		
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
		
		<!--Uso del jquery para validar los formularios-->
		<script src="../../recursos/js/jquery-1.10.2.min.js"></script>
		<script src="../../recursos/js/jquery.validate.js"></script>
		
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
          <a class="navbar-brand" href="#">ETS: Ingeniería de SoftWare</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="../codigos.php">Ver codigos</a></li>
            <li><a href="../crear_codigo/lenguaje.php">Escribir codigo</a></li>
			<li class="active"><a href="#">Grupos</a></li>
            <li><a href="../../usuarios/salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
		<!--Columnas con contenido-->
		<div class="container" ><!--inicia contenedor-->
		
		<!--Lista de grupos-->
		<h2 align="left">Grupos:</h2>
		<?php
			/*Generando la informacion para cada uno de los nodos en la lista de grupos*/
			$grupos= new SimpleXMLElement('../../recursos/xml/grupos.xml', 0, true);//se abre el archivo
			//generamos la lista de grupos a usar
	
			foreach ($grupos as $grupo)
			{
				$nombre=$grupo->nombre;
				$asignatura=$grupo->asignatura;

				echo '<div align="center">';
				echo '<div class="row"><div class="col-md-8">';//inicia reja grande
				echo '<h3>grupo: '.$nombre.' / ' .$asignatura. '</h3>';//nombre del grupo
				
					echo '<div class="row" ><div class="col-md-6">';//inicia 1ra subreja
					echo '<form action="grupo.php" method="post" name="ver">';
					echo '<input name="nombre" type="hidden" value="'.$nombre.'">';
					echo '<input name="asignatura" type="hidden" value="'.$asignatura.'">';
					echo '<button type="submit" name="ver" class="btn btn-primary">Ver grupo</button>';//boton para ver un grupo
					echo '</form>';
				echo '</div>';//termina 1ra subreja
				echo '<div class="col-md-6">';//inicia 4ta subreja
					echo '<form action="ver_grupos.php" method="post" name="borrar">';
					echo '<input name="bnombre" type="hidden" value="'.$nombre.'">';
					echo '<input name="basignatura" type="hidden" value="'.$asignatura.'">';
					echo '<button type="submit" name="borrar" class="btn btn-danger">Borrar grupo</button>';//boton para borrar un grupo
					echo '</form>';
				echo '</div>';//termina 4ta subreja
				echo '</div></div></div>';//termina reja grande
				echo '</div>';
			
			
			}
			?>
			
		</br></br>
		<!--Crear grupo-->	
		<div id="creargru" align="left" style="width: 500px">
		<button class="btn btn-default" onclick="document.getElementById('nuegru').style.display=(document.getElementById('nuegru').style.display=='none')? 'block':'none'">Agregar un grupo</button>
		</br></br>

			<!--script validacion formulario-->
		<script type="text/javascript">
			$(function(){
				$('#nuegru').validate({
					rules :{
						nombre : {
							required : true
						},
						asignatura : {
							required : true
						}
					},
					messages : {
						nombre : {
							required : "Debe ingresar un nombre"
						},
						asignatura : {
							required : "Debe ingresar una asignatura"
						}
					}
				});    
			});
		</script>
		
		<form method="post" name="nuegru" id="nuegru" action="ver_grupos.php" role="form" style="display:none">
		
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input class="form-control" type="text" name="nombre" id="nombre">
		</div>
		
		<div class="form-group">
			<label for="asignatura">Asignatura</label>
			<input class="form-control" type="text" name="asignatura" id="asignatura">
		</div>
			
		
			<button class="btn btn-default" align="right" type="submit" name="crear" >Crear grupo</button>
			
		</form>
		</div>
		
	</div><!--Final container-->
	
	
	</body>
</html>