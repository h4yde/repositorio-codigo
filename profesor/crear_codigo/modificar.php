<?php
	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../usuarios/entrar.php');
	
	//recibiendo variables metodo post
	
	
	$lenguaje=$_POST['lenguaje'];
	$ar_xml= '../../recursos/xml/' . $lenguaje . '.xml';
	$nom_archivo=$_POST['nombre'];
	$nfil=$_POST['num_filas'];
	$ncol=$_POST['num_col'];
	$nlin=$_POST['lineas'];
	$nuevnodo=0;
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<title>Escribiendo codigo</title>
		
		<link href="../../recursos/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="../../recursos/js/jquery.min.js"></script>
		<script src="../../recursos/js/jquery-ui.js"></script>
		
		<!-- Bootstrap core CSS -->
		<link href="../../recursos/bs/dist/css/bootstrap.css" rel="stylesheet">
		
		<!-- Bootstrap theme -->
		<link href="../../recursos/bs/dist/css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../../recursos/css/theme.css" rel="stylesheet">
		
		<!--Funciones autocompletado-->
		<script>
		$(document).ready(function() {
			var myArr = [];
			var url="../../recursos/xml/"+document.getElementById('lenajax').value+".xml";
			$.ajax({
				type: "GET",
				url: url, // nombre del archivo a usar
				dataType: "xml",
				success: parseXml,
				complete: setupAC,
				failure: function(data) {
					alert("No se encontro el archivo XML"); //error
				}
			});
	
			function parseXml(xml)
			{
				//buscando cada valor
				$(xml).find("sentencia").each(function()
				{
					myArr.push($(this).attr("label"));
					
				});	
			}
		
			
			function setupAC() {
				$("input#searchBox").autocomplete({
					source: myArr,
					minLength: 1,
					select: function(event, ui) {
						$("input#searchBox").val(ui.item.value);
						$("#searchForm").submit();
					}
				});
			}
		});
		</script>
		
		<!--Funciones manipulacion del codigo-->
		<script type="text/javascript">
			var codigo = [];
	
			function insertarCodigo(linea) {
				var elmTBODY = document.getElementById('CuerpoTabla');
				var elmTR;
				var elmTD;
				var elmText;
				
					//agregando al array
					/*Se agrego el valor '6|6|6' para garantizar que al momento de unir el arreglo
					para ser enviado en el metodo Post la division de la cadena sea correcta*/
					codigo.push(linea+'6|6|6');
					
					//donde se insertara la proxima linea
					elmTR = elmTBODY.insertRow(document.getElementById('CuerpoTabla').rows.length);
				
					//insertando numero de fila
					elmTD = elmTR.insertCell(0);
					elmText = document.createTextNode(document.getElementById('CuerpoTabla').rows.length);
					elmTD.appendChild(elmText);
					
					//insertando codigo fila
					elmTD = elmTR.insertCell(1);
					elmText = document.createTextNode(linea);
					elmTD.appendChild(elmText);					
			}
			
			function leerTex(){
				var i;
				for(i=0; i<<?=$nlin?>; i++)
				{
					var elmTBODY = document.getElementById('CuerpoTabla');
					var elmTR;
					var elmTD;
					var elmText;
				
					//agregando al array
					/*Se agrego el valor '6|6|6' para garantizar que al momento de unir el arreglo
					para ser enviado en el metodo Post la division de la cadena sea correcta*/
					codigo.push(document.getElementById('textex').rows[i].cells[0].innerText+'6|6|6');
					
					//donde se insertara la proxima linea
					elmTR = elmTBODY.insertRow(document.getElementById('CuerpoTabla').rows.length);
				
					//insertando numero de fila
					elmTD = elmTR.insertCell(0);
					elmText = document.createTextNode(document.getElementById('CuerpoTabla').rows.length);
					elmTD.appendChild(elmText);
					
					//insertando codigo fila
					elmTD = elmTR.insertCell(1);
					elmText = document.createTextNode(document.getElementById('textex').rows[i].cells[0].innerText);
					elmTD.appendChild(elmText);	
				}
			}
			
			function insertarFila() {
				var elmTBODY = document.getElementById('CuerpoTabla');
				var elmTR;
				var elmTD;
				var elmText;
				
				if(document.getElementById('CuerpoTabla').rows.length==<?=$nfil?>) alert('Ha llegado al limite de las filas establecidas.');
				
				else
				{
					//agregando al array
					/*Se agrego el valor '6|6|6' para garantizar que al momento de unir el arreglo
					para ser enviado en el metodo Post la division de la cadena sea correcta*/
					codigo.push(document.getElementById('searchBox').value+'6|6|6');
					
					//donde se insertara la proxima linea
					elmTR = elmTBODY.insertRow(document.getElementById('CuerpoTabla').rows.length);
				
					//insertando numero de fila
					elmTD = elmTR.insertCell(0);
					elmText = document.createTextNode(document.getElementById('CuerpoTabla').rows.length);
					elmTD.appendChild(elmText);
					
					//insertando codigo fila
					elmTD = elmTR.insertCell(1);
					elmText = document.createTextNode(document.getElementById('searchBox').value);
					elmTD.appendChild(elmText);
										
				}
			}
 
			function eliminarFila() {
				var elmTBODY = document.getElementById('CuerpoTabla');
				
				if(document.getElementById('CuerpoTabla').rows.length==0) alert('No hay filas.');
				else
				{
					elmTBODY.deleteRow(document.getElementById('CuerpoTabla').rows.length-1);
					codigo.pop();
				}
				
			}
			
			/*Almacena las variables obtenidas en el formulario test para guardarlas tras
			en php y generar el archivo*/
			function setValue()
			{
				var codigo1 = codigo.toString();
				
				//colocamos el valor en el campo
				document.test.code.value=codigo1;
			}
		</script>
	</head>
	<body>
	
	<!--Campo con el valor del lenguaje para poder ser usado en ajax-->
		<input type="hidden" id="lenajax" value="<?=$lenguaje?>"/>
	
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
            <li class="active"><a href="lenguaje.php">Escribir codigo</a></li>
			<li><a href="../grupos/ver_grupos.php">Grupos</a></li>
            <li><a href="../../usuarios/salir.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
		<div class="container">
		
		<h3>Escribir codigo</h3>
		<table>
		<tr><td>
		<!--Guardar salir-->
			<form action="guardar_ar.php" method="post" name="test" onSubmit="setValue()">
				<input name="code" type="hidden">
				<input name="lenguaje" type="hidden" value="<?=$lenguaje?>">
				<input name="brush" type="hidden" value="<?=$brush?>">
				<input name="num_filas" type="hidden" value="<?=$nfil?>">
				<input name="num_col" type="hidden" value="<?=$ncol?>">
				<input name="nombre_archivo" type="hidden" value="<?=$nom_archivo?>">
				<button type="submit" name="Guardar" class="btn btn-primary">Guardar</button>
			</form>
		</td><!--<td>	
			<button name="cancelar" onclick="../../codigos.php" class="btn btn-danger">Cancelar</button>
			</td>--></tr></table>
			</br></br>
		<!--Agregar una sentencia escribir codigo-->
		<div class="form-group">
			<table WIDTH=700><tr><td align="center">
			<label for="searchBox" class="col-lg-2 control-label">Sentencia</label>
			</td><td>
			<input type="text" id="searchBox" name="searchString" class="form-control"></input>
			</td><td>
			<button name="searchKeyword" id="searchKeyword" onclick="insertarFila()" class="btn btn-info">Agregar</button>
			</td></table>
		</div>
		
		</br></br>
		<!--Tabla que muesta el codigo-->

		<table summary="Editando codigo" WIDTH=700>
			<thead>
				<tr>
					<th>#</th>
					<th>Sentencia</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2"><button onclick="eliminarFila()" class="btn btn-warning btn-xs btn-block">Borrar fila</button></td>
				</tr>
			</tfoot>
			<tbody id="CuerpoTabla">
			</tbody>
		</table>
		
	</div>
		
		<!--Insersion de filas, la insercion se hace en javascript y la lectura con php-->
		<?php
			
			$file = fopen("../../recursos/codigos/". $nom_archivo . ".txt", "r") or exit("Error: no se puede abrir archivo");
			
			/*Leyendo y guardando archivo en un arreglo*/
			while(!feof($file))
			{
				$texto[]= fgets($file);
			}
			fclose($file);
			
			
			//escribiendo tabla
			echo '<table style="display: none" id="textex">';
			for($nuevnodo=0; $nuevnodo<$nlin; $nuevnodo++)
			{
				echo '<tr><td>'.$texto[$nuevnodo].'</td></tr>';
			}
			echo '</table>';
		?>
		<script type="text/javascript">
			leerTex();
		</script>
		
	
	
	</body>
</html>