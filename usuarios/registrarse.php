<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Registrarse</title>
		
		<!--Uso del jquery para validar los formularios-->
		<script src="../recursos/js/jquery-1.10.2.min.js"></script>
		<script src="../recursos/js/jquery.validate.js"></script>
		
		<!-- Bootstrap core CSS -->
		<link href="../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../recursos/css/jumbotron-narrow.css" rel="stylesheet">
				
	</head>
	<body>
		<!--Script para el formulario, declaracion de como se validara (condiciones) y los mensajes-->
		<script type="text/javascript">
			$(function(){
				$('#miForm4').validate({
					rules :{
						cnom : {
							required : true,
							minlength: 5
						},
						con : {
							required : true,
							minlength: 6
						},
						c_con : {
							required : true,
							minlength: 6,
							equalTo: "#con"
						},
						cmail : {
							required : true,
							email    : true
						}
					},
					messages : {
						cnom : {
							required : "Ingrese un nombre",
							minlength: "El nombre debe tener al menos 5 caracteres"
						},
						con : {
							required : "Ingrese una contraseña",
							minlength: "La contraseña debe tener al menos 6 caracteres"
						},
						c_con : {
							required : "Confirme la contraseña",
							minlength: "La confirmacion debe tener al menos 6 caracteres",
							equalTo: "La confirmacion no es correcta"
						},
						cmail : {
							required : "Debe ingresar un email",
							email    : "Debe ingresar un email valido"
						}
					}
				});    
			});
		</script>
		
		<!--Barra de navegacion-->
		<div class="container">
			<div class="header">
				<ul class="nav nav-pills pull-right">
					<li class="active"><a href="#">Registrarse</a></li>
					<li><a href="entrar.php">Entrar</a></li>
				</ul>
				<h3 class="text-muted">Registrarse</h3>
			</div>
			
		<!--Formulario que valida el script y manda los campos-->
		
		<form method="post" action="guardando_usu.php" id="miForm4" class="form-horizontal" role="form">
			<!--Nombre-->
			<div class="form-group">
				<label for="cnom" class="col-lg-2 control-label">Nombre</label>
				<div class="col-lg-10">
					<input type="text" class="form-control required" id="cnom" name="cnom" placeholder="Nombre">
				</div>
			</div>
			
			<!--contraseña-->
			<div class="form-group">
				<label for="cnom" class="col-lg-2 control-label">Contraseña</label>
				<div class="col-lg-10">
					<input type="password" class="form-control required" id="con" name="con" placeholder="Contraseña">
				</div>
			</div>
			
			<!--confirmar contraseña-->
			<div class="form-group">
				<label for="c_cnom" class="col-lg-2 control-label">Confirmación contraseña</label>
				<div class="col-lg-10">
					<input type="password" class="form-control required" id="c_con" name="c_con" placeholder="Confirmar contraseña">
				</div>
			</div>
			
			<!--email-->
			<div class="form-group">
				<label for="cmail" class="col-lg-2 control-label">E-mail</label>
				<div class="col-lg-10">
					<input type="text" class="form-control required" id="cmail" name="email" placeholder="ejemplo@ejemplo.com">
				</div>
			</div>
			
			<!--boton-->
			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<input type="submit" class="btn btn-default" value="Enviar">
				</div>
			</div>
		</form>
		
		</div> <!-- /container -->
	</body>
</html>