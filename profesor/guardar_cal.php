<?php
	//punt='+puntu.options[puntu.selectedIndex].value+'&fav='+fav+'&usuario='+usuario+'&nombre=<?=$nombre
	$punt=$_GET['punt'];
	$fav=$_GET['fav'];
	$usuario=$_GET['usuario'];
	$nombre=$_GET['nombre'];
	
	echo $punt." ".$fav." ".$usuario." ".$nombre;
	
	/*Abriendo el documento XML para modificar la calificacion y agregar a favoritos*/
	
	
	$comentarios= new SimpleXMLElement('../recursos/xml/comentarios/'.$nombre.'.xml', 0, true);//se abre el archivo
	
	foreach ($comentarios as $coment)
	{
		if($coment->nombre==$usuario)//el usuario ya comento
		{
			$coment->calificacion=$punt;
			if($fav=="si") $coment->desta=$fav;
		}
	}
		$comentarios->asXML('../recursos/xml/comentarios/'.$nombre.'.xml');
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";


?>
