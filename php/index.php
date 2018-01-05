<?php 
require 'bd.php';
require 'controladores/ctrl_alumnos.php';
require 'controladores/util.php';
require 'auth.php';
$msql = new bd;

limpiaParams(); // Sólo limpia $_GET o $_POST
session_start();

if(isset($_POST['func'])){

	if($_POST['func'] == 'auth')
		auth();
	elseif(isset($_SESSION['login'])){

		switch ($_POST['func']) {
			case 'alumnos':
				alumnos();
				break;

			case 'logout':
				logout();
				break;

			case 'alumno_id':
				alumno_id();
				break;

			case 'alumno_cu':
				alumno_cu();
				break;

			case 'insertaAlumno':
				insertaAlumno();
				break;
			
			default:
				echo jsonErr('funcion no existente');
				break;
		}
	}
	else
		echo jsonErr('Acceso denegado');
	//echo '\n session : '.session_id();
}

//echo 'hola fin';
//print_r( $_POST);



 ?>
