<?php 
require 'bd.php';
require 'controladores/ctrl_alumnos.php';
require 'controladores/util.php';
require 'auth.php';
$msql = new bd;

limpiaParams(); // Sólo limpia $_GET y $_POST

if(isset($_POST['func'])){

	if($_POST['func'] == 'auth')
		auth();
	elseif(isset($_SESSION)){

		switch ($_POST['func']) {
			case 'alumnos':
				alumnos();
				break;
			
			default:
				# code...
				break;
		}
	}
	else
		echo 'Acceso denegado';
}

//echo 'hola fin';
//print_r( $_POST);



 ?>
 