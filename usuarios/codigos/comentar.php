<?php
 
	$existe = 0;
	$usuario = $_POST['usuario'];
	$nombre = $_POST['nombre'];
	$lenguaje = $_POST['lenguaje'];
	$brush = $_POST['brush'];
	$comentario = $_POST['comentario'];
	
	/*Creacion del nodo en el archivo correpondiente*/
		
	$comentarios= new SimpleXMLElement('../../recursos/xml/comentarios/'.$nombre.'.xml', 0, true);//se abre el archivo
	
	foreach ($comentarios as $coment)
	{
		if($coment->nombre==$usuario)//el usuario ya comento
		{
			$existe = 1;
			echo "<script language='javascript'>"; 
			echo "alert('Ya has comentado, el comentario no se guardara.')"; 
			echo "</script>";
		}
	}
	
	if($existe!=1)
	{
	$coment = $comentarios->addChild('coment');
		$coment->addChild('nombre', $usuario);
		$coment->addChild('calificacion', '6');
		$coment->addChild('desta', 'no');
		$coment->addChild('texto', $comentario);	
			
	$comentarios->asXML('../../recursos/xml/comentarios/'.$nombre.'.xml');//se guarda el comentario
	
		echo "<script language='javascript'>"; 
		echo "alert('Se ha guardado el comentario.')"; 
		echo "</script>";
	}
	header('Refresh:0; url=codigo.php?nombre='.$nombre.'&lenguaje='.$lenguaje.'&brush='.$brush);
?>