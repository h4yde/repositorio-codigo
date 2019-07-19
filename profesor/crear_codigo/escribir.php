<?php
	//codigo pagina de profesor
	session_start();
	if (isset($_SESSION['prof'])){ //si hay sesion
			if($_SESSION['prof']!="si"){//si no es el profesor
				header('Refresh:0; url=../usuarios/entrar.php');
			}
		
	}else header('Refresh:0; url=../usuarios/entrar.php');
	
	//asignacion del brush
	switch($_GET['lenguaje'])
	{
		case "c":
			$brush="shBrushCpp";
		break;
		case "cpp":
			$brush="shBrushCpp";
		break;
		case "actionscript3":
			$brush="shBrushAS3";
		break;
		case "bash":
			$brush="shBrushBash";
		break;
		case "coldfusion":
			$brush="shBrushColdFusion";
		break;
		case "csharp":
			$brush="shBrushCSharp";
		break;
		case "css":
			$brush="shBrushCss";
		break;
		case "delphi":
			$brush="shBrushDelphi";
		break;
		case "diff":
			$brush="shBrushDiff";
		break;
		case "erl":
			$brush="shBrushErlang";
		break;
		case "groovy":
			$brush="shBrushGroovy";
		break;
		case "java":
			$brush="shBrushJava";
		break;
		case "jfx":
			$brush="shBrushJavaFX";
		break;
		case "jscript":
			$brush="shBrushJScript";
		break;
		case "perl":
			$brush="shBrushPerl";
		break;
		case "php":
			$brush="shBrushPhp";
		break;
		case "plain":
			$brush="shBrushPlain";
		break;
		case "powershell":
			$brush="shBrushPowerShell";
		break;
		case "python":
			$brush="shBrushPython";
		break;
		case "ruby":
			$brush="shBrushRuby";
		break;
		case "sass":
			$brush="shBrushSass";
		break;
		case "scala":
			$brush="shBrushScala";
		break;
		case "sql":
			$brush="shBrushSql";
		break;
		case "vb":
			$brush="shBrushVb";
		break;
		case "xml":
			$brush="shBrushXml";
		break;
	}
	
	$lenguaje=$_GET['lenguaje'];
	$ar_xml= '../../recursos/xml/' . $_GET['lenguaje'] . '.xml';
	$nuevo_archivo=$_GET['nombre'];
	$nfil=$_GET['nfil'];
	$ncol=$_GET['ncol'];
	$nuevnodo=0;
	
	
	
	//comprobando la disponibilidad para un nombre nuevo
	$n_nom=0;
		
	$codigos= new SimpleXMLElement('../../recursos/xml/codigos.xml', 0, true);
		foreach ($codigos as $codigo)
		{
			if($codigo->nombre==$nuevo_archivo)
			{
				$n_nom=1;
			}
		}
	if($n_nom==1)
	{
		echo "<script language='javascript'>"; 
		echo "alert('Error: El nombre del archivo ya esta en uso, se le rediccionara a la pagina anterior.')"; 
		echo "</script>";
		header('Refresh:0; url=lenguaje.html');
	}
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
					alert("XML File could not be found"); //error
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
          <a class="navbar-brand" href="#">ETS: Ingeniería de SoftWare</a>
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
				<input name="nombre_archivo" type="hidden" value="<?=$nuevo_archivo?>">
				<button type="submit" name="Guardar" class="btn btn-primary">Guardar</button>
			</form>
		</td><td>	
			<button name="cancelar" onclick="../codigos.php" class="btn btn-danger">Cancelar</button>
			</td></tr></table>
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
	
	
	</body>
</html>