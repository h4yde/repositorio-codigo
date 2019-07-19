<?php

	$nombre=$_POST['nombre'];
	$doc = new DOMDocument;
	$numnodo=0;
	$doc->load('../../recursos/xml/codigos.xml');

	/*numero de nodo*/
	$codigosN= new SimpleXMLElement('../../recursos/xml/codigos.xml', 0, true);//se abre el archivo
	
	foreach ($codigosN as $codigo)
	{
		if($codigo->nombre!=$nombre) $numnodo=$numnodo+1;
		else break;
	}
	echo $numnodo;
	
	/*Borrar nodo con dom*/
	$codigos = $doc->documentElement;

	// recuperamos el nodo y lo borramos
	$codigo = $codigos->getElementsByTagName('codigo')->item($numnodo);
	$borrado = $codigos->removeChild($codigo);

	$doc->save('../../recursos/xml/codigos.xml');
	
	/*Borramos los archivos asociados al codigo
	unlink('../../recursos/xml/comentarios/' . $nombre . '.xml');//borramos los comentarios
	unlink('../../recursos/codigos/' . $nombre . '.txt');//borramos el codigo en si*/

	header('Refresh:0; url=../codigos.php');

?>