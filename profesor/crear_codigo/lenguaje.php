<?php
	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../usuarios/entrar.php');
	
	$existe=0;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Profesor creando codigo</title>
		
		<!-- Bootstrap core CSS -->
		<link href="../../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">
		
		<!-- Bootstrap theme -->
		<link href="../../recursos/bs/dist/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../../recursos/css/theme.css" rel="stylesheet">
		
		<!--Scripts-->
		<link href="../../recursos/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="../../recursos/js/jquery.min.js"></script>
		<script src="../../recursos/js/jquery-ui.js"></script>
		
		<!--Uso del jquery para validar los formularios-->
		<script src="../../recursos/js/jquery-1.10.2.min.js"></script>
		<script src="../../recursos/js/jquery.validate.js"></script>
		
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
            <li><a href="../codigos.php">Ver codigos</a></li>
            <li class="active"><a href="#">Escribir codigo</a></li>
			<li><a href="../grupos/ver_grupos.php">Grupos</a></li>
            <li><a href="../../usuarios/salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
	<div class="container">
		
		<h3>Configuración del codigo:</h3></br></br>
		<!--script validacion formulario-->
		<script type="text/javascript">
			$(function(){
				$('#selenguaje').validate({
					rules :{
						lenguaje : {
							required : true
						},
						ncol : {
							digits: true
						},
						nfil : {
							required : true,
							digits: true
						},
						nombre : {
							required : true
						}
					},
					messages : {
						lenguaje : {
							required : "Debe elegir un lenguaje"
						},
						ncol : {
							digits: "Ingrese un numero"
						},
						nfil : {
							required : "Debe ingresar un numero de filas",
							digits: "Ingrese un numero"
						},
						nombre : {
							required : "Debe ingresar un nombre"
						}
					}
				});    
			});
		</script>
		
		<!--formulario-->
		<form id="selenguaje" action="escribir.php" role="form">
		
		<div class="form-group">
			<label for="lenguaje">Lenguaje</label>
			<select class="form-control" name="lenguaje" id="lenguaje">
				<option select value>Lenguaje</option>
				<option value="actionscript3">ActionScript3</option>
				<option value="bash">Bash/shell</option>
				<option value="coldfusion">ColdFusion</option>
				<option value="csharp">C#</option>
				<option value="c">C</option>
				<option value="cpp">Cpp</option>
				<option value="css">CSS</option>
				<option value="delphi">Delphi</option>
				<option value="diff">Diff</option>
				<option value="erl">Erlang</option>
				<option value="groovy">Groovy</option>
				<option value="jscript">JavaScript</option>
				<option value="java">Java</option>
				<option value="jfx">JavaFX</option>
				<option value="perl">Perl</option>
				<option value="php">PHP</option>
				<option value="plain">Plain Text</option>
				<option value="powershell">PowerShell</option>
				<option value="python">Python</option>
				<option value="ruby">Ruby</option>
				<option value="sass">Sass</option>
				<option value="scala">Scala</option>
				<option value="sql">SQL</option>
				<option value="vb">Visual Basic</option>
				<option value="xml">XML</option>
			</select>
		</div>
		
		<div class="form-group">
			<label for="ncol">Numero de columnas</label>
			<input class="form-control" type="text" name="ncol" id="ncol">
		</div>
		
		<div class="form-group">
			<label for="nfil">Numero de filas</label>
			<input class="form-control" type="text" name="nfil" id="nfil">
		</div>
			
		<div class="form-group">
			<label for="nombre">Nombre del archivo</label>
			<input class="form-control" type="text" name="nombre" id="nombre">
		</div>
			
		
			<button class="btn btn-default" align="right" type="submit" name="enviar" onclick="setValue()">Enviar</button>
			
		</form>
		
		</div>
	</body>
</html>