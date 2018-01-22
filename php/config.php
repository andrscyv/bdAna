<?php 


$funcionesRegistradas = array(
					"alumnos" => array("alumnos", "alumno_id", "alumno_cu", "insertaAlumno"),
					"auth" => array("logout", "nuevoUsuario"),
					"authPublico" => array("auth","tengoSesion"),
					"actExtra" => array("insertaActividad", "actividadesExtra"),
					"sanciones" => array("insertaSancion", "sanciones"),
					"estancias" => array("insertaUniversidad", "universidades","registraEstanciaAlumno"),
					"comentarios" => array("insertaComentCu","comentarios", "comentarios_cu"),
					"materias" => array("insertaMateria", "materias", "registraMatAlum")
				);

$rutasRegistradas = array("alumnos" => "controladores/ctrl_alumnos.php",
						  "auth" => "auth.php",
						  "authPublico" => "auth.php",
							"actExtra" => "controladores/ctrl_actividadesExtra.php",
							"sanciones" => "controladores/ctrl_sanciones.php",
							"estancias" => "controladores/ctrl_estancias.php",
							"comentarios" => "controladores/ctrl_comentarios.php",
							"materias" => "controladores/ctrl_materias.php");

$bdConfig = array( "servername" => "localhost",
					"username" => "root",
					"password" => "",
					"dbName" =>"alumnoscompu");



 ?>