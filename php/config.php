<?php 


$funcionesRegistradas = array(
					"alumnos" => array("alumnos", "alumno_id", "alumno_cu", "insertaAlumno"),
					"auth" => array("logout", "nuevoUsuario"),
					"authPublico" => array("auth","tengoSesion"),
					"actExtra" => array("insertaActividad", "actividadesExtra")
				);
$rutasRegistradas = array("alumnos" => "controladores/ctrl_alumnos.php",
						  "auth" => "auth.php",
						  "authPublico" => "auth.php",
							"actExtra" => "controladores/ctrl_actividadesExtra.php");

$bdConfig = array( "servername" => "localhost",
					"username" => "root",
					"password" => "",
					"dbName" =>"alumnoscompu");



 ?>