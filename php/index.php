<?php 
require 'config.php';
require 'bd.php';
require 'util.php';
//equire 'auth.php';
//require 'controladores/ctrl_alumnos.php';
$msql = new bd($bdConfig);

limpiaParams(); // Sólo limpia $_GET o $_POST
session_start();

if(isset($_POST['func'])){

	if($_POST['func'] == 'auth'){
		require_once("auth.php");
		auth();
	}
	elseif(isset($_SESSION['login'])){

		if( array_key_exists($_POST["dominio"], $funcionesRegistradas) and 
			in_array( $_POST["func"], $funcionesRegistradas[$_POST["dominio"]] ) ){
			require_once($rutasRegistradas[$_POST["dominio"]]);
			$_POST["func"]();
		}
		else
			echo jsonErr("funcion o dominio no existente");

	}
	else
		echo jsonErr('Acceso denegado');
	//echo '\n session : '.session_id();
}

//echo 'hola fin';
//print_r( $_POST);



 ?>
