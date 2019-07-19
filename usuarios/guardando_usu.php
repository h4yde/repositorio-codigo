<?php
    $cnom = $_POST["cnom"];
    $n_nom=0;
		
		$login= new SimpleXMLElement('../recursos/xml/login.xml', 0, true);
			foreach ($login as $usuario)
			{
				if($usuario->nombre==$_POST['cnom'])
				{
					$n_nom=1;
				}
			}

    if( $n_nom==1){//nombre de usuario en uso
		echo "<script language='javascript'>"; 
		echo "alert('Error: El nombre de usuario ya esta en uso. Se le redireccionara a la pagina anterior.')"; 
		echo "</script>";
		header('Refresh:0; url=registrarse.php');
	}
    else{//nombre disponible
	
		//recogemos las demas variables
		$con = $_POST["con"];
		$cmail = $_POST["cmail"];
		
		//agregamos un nuevo nodo
		$usuario = $login->addChild('usuario');
			$usuario->addChild('nombre', $cnom);
			$usuario->addChild('contra', $con);
			$usuario->addChild('correo', $cmail);
			
		$login->asXML('../recursos/xml/login.xml'); //guardamos el archivo
			
		//notificamos de la creacion y redireccionamos al login
		echo "<script language='javascript'>"; 
		echo "alert('Usuario creado correctamente')"; 
		echo "</script>";
		header('Refresh:0; url=entrar.php');
			
	}
?>