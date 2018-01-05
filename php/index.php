<?php 
require 'bd.php';
require 'controladores/ctrl_alumnos.php';
require 'controladores/util.php';
require 'auth.php';
$msql = new bd;

limpiaParams(); // Sólo limpia $_GET o $_POST
session_start();
$funcionesRegistradas = array("alumnos", "logout", "alumno_id", "alumno_cu", "insertaAlumno");

if(isset($_POST['func'])){

	if($_POST['func'] == 'auth')
		auth();
	elseif(isset($_SESSION['login'])){

		if( in_array($_POST["func"], $funcionesRegistradas) )
			$_POST["func"]();
		else
			echo jsonErr("funcion no existente");

	}
	else
		echo jsonErr('Acceso denegado');
	//echo '\n session : '.session_id();
}

//echo 'hola fin';
//print_r( $_POST);



 ?>
