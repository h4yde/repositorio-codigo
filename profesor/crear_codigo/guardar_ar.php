<?php
	//recoleccion de las variables del codigo
	$i;
	$existe=0;//variable para verificar si el archivo ya existia
	$nombre=$_POST['nombre_archivo'];
	$lenguaje=$_POST['lenguaje'];
	$brush=$_POST['brush'];
	$ncol=$_POST['num_col'];
	$nfil=$_POST['num_filas'];
	$cod = $_POST['code'];
	$codigo1 = explode ('6|6|6,',$cod);
	//variable lineas
	$lineas = count($codigo1);
	
	//limpieza ultima linea del codigo
	$codigo1[$lineas-1] = substr($codigo1[$lineas-1], 0, -5);
	
	/*Creacion del nodo en el archivo codigos.xml*/
		
	$codigos= new SimpleXMLElement('../../recursos/xml/codigos.xml', 0, true);//se abre el archivo
	
	foreach ($codigos as $codigo)
	{
		if($codigo->nombre==$nombre)//si ya existe el archivo
		{
			$codigo->lineas=$lineas;
			$existe=1;//si existe
		}
	}
	
	if($existe==0)//si el archivo no existe
	{
		$codigo = $codigos->addChild('codigo');
			$codigo->addChild('nombre', $nombre);
			$codigo->addChild('lenguaje', $lenguaje);
			$codigo->addChild('brush', $brush);
			$codigo->addChild('ncol', $ncol);
			$codigo->addChild('nfil', $nfil);
			$codigo->addChild('lineas', $lineas);
	}		
			
	$codigos->asXML('../../recursos/xml/codigos.xml');//se guarda el archivo
			
	/*Guardando el codigo en un archivo .txt*/
	$archivo= fopen('../../recursos/codigos/' . $nombre . '.txt', 'w+') or die('Error: problema al crear el archivo');
	
	for($i=0; $i<$lineas; $i++)
	{
		fputs($archivo, $codigo1[$i]);
		//fputs($archivo, chr(13).chr(10));
	}
	fclose($archivo);
	
	if(file_exists('../../recursos/xml/comentarios/' . $nombre . '.xml'))//si el xml de comentarios existe
	{
		echo "chido";
	}
	else //si no existe
	{
		/*Generando comentarios para el archivo*/
		$comentarios= fopen('../../recursos/xml/comentarios/' . $nombre . '.xml', 'w+') or die('Error: problema al crear xml de comentarios');
		fputs($comentarios, '<?xml version="1.0" encoding="UTF-8"?>');//primer linea
		fputs($comentarios, chr(13).chr(10));
		fputs($comentarios, '<!DOCTYPE comentarios SYSTEM  "../dtd/comentarios.dtd">');//dtd
		fputs($comentarios, chr(13).chr(10));
		fputs($comentarios, '<comentarios>');
		fputs($comentarios, chr(13).chr(10));
		fputs($comentarios, '</comentarios>');
		fclose($comentarios);
	}
	
	
	if(file_exists('../../recursos/codigos/' . $nombre . '.txt'))
	{
		echo "<script language='javascript'>"; 
		echo "alert('Codigo guardado correctamente.')"; 
		echo "</script>";
		header('Refresh:0; url=../codigos.php');
	}
	else
	{
		echo "<script language='javascript'>"; 
		echo "alert('Error: el codigo no se ha podido guardar. Vuelva a intentarlo.')"; 
		echo "</script>";
		header('Refresh:0; url=lenguaje.html');
	}
	//ARISWELL
?>