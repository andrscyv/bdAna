<?php 


$funcionesRegistradas = array(
					"alumnos" => array("alumnos", "alumno_id", "alumno_cu", "insertaAlumno"),
					"auth" => array("logout", "nuevoUsuario")
				);
$rutasRegistradas = array("alumnos" => "controladores/ctrl_alumnos.php",
						  "auth" => "auth.php");

$bdConfig = array( "servername" => "localhost",
					"username" => "alumnoscompu",
					"password" => "N7kLGKisTdgI4NJq",
					"dbName" =>"alumnoscompu");



 ?>