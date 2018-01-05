<?php 
require 'config.php';
require 'bd.php';
require 'util.php';
require 'auth.php';
require 'controladores/ctrl_alumnos.php';
$msql = new bd($bdConfig);

limpiaParams(); // Sólo limpia $_GET o $_POST
session_start();

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
