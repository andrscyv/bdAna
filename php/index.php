<?php 
require 'config.php';
require 'bd.php';
require 'util.php';
//equire 'auth.php';
//require 'controladores/ctrl_alumnos.php';
$msql = new bd($bdConfig);

limpiaParams(); // Sólo limpia $_GET o $_POST
session_start();
$json = file_get_contents('php://input'); 
$_POST = json_decode($json, true);
if(isset($_POST['func'])){
	if(in_array( $_POST['func'] , $funcionesRegistradas["authPublico"])){
		require_once("auth.php");
		$_POST['func']();
	}
	elseif(isset($_SESSION['login'])){

		if( isset($_POST["dominio"]) ){
		
			if( array_key_exists($_POST["dominio"], $funcionesRegistradas) and 
				in_array( $_POST["func"], $funcionesRegistradas[$_POST["dominio"]] ) ){
				require_once($rutasRegistradas[$_POST["dominio"]]);
				$_POST["func"]();
			}
			else
				echo jsonErr("funcion o dominio no existente");
		}
		else
			echo jsonErr("Sin dominio especificado");

	}
	else{
		//echo "prueba9";
		echo jsonErr('Acceso denegado');
	}
	//echo '\n session : '.session_id();
}
else
	echo jsonErr("Sin funcion especificada");
//echo jsonErr('Acceso denegado');
//echo 'hola fin';
//print_r( $_POST);



 ?>
