<?php 

//func = insertaEscuelaAlt; param = nombre;
function insertaEscuelaAlt(){
	global $msql;
	$conn = $msql->conn;
	$params = array("nombre");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from escuelasAlternas where nombre = :nombre", 
									array("nombre"));
			$stmt->execute();

			if($stmt->rowCount() == 0){

				$stmt = $msql->sqlPrepPost("INSERT INTO escuelasAlternas(nombre)
						VALUES (:nombre)", $params);

				$stmt->execute();
				$idEscuela = $conn->lastInsertId();
				$res = json(array("idEscuela" => $idEscuela));

			}
			else
				$res = jsonErr("Escuela ya existe");

		}
		else 
			$res = jsonErr("Error en parametros");
	}
	catch(PDOException $e){
		//$res = jsonErr($e->getMessage());
		$res = jsonErr($e->getMessage());
	}

	echo $res;
 }

 function escuelasAlt(){
	global $msql;
	$res = $msql->cons("select * from escuelasAlternas");
	echo json($res);
}

//func = registraAlumEscAlt; params = cuAlum, idEsc, carrera;
function registraAlumEscAlt(){

	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum","idEsc", "carrera");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT idAlum FROM alumnos
				WHERE cu =:cuAlum",	array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $row["idAlum"];

				$stmt = $msql->sqlPrepPost("SELECT * FROM alumnos_escuelas 
									WHERE idAlum =:idAlum AND idEsc = :idEsc",
									array("idAlum", "idEsc"));
				$stmt->execute();
				if($stmt->rowCount() == 0){

					$params = array("idAlum", "idEsc", "carrera");
					$stmt = $msql->sqlPrepPost("INSERT INTO alumnos_escuelas(idAlum, idEsc, 
							carrera)
							VALUES (:idAlum, :idEsc, :carrera)", $params);

					$stmt->execute();
					$res = jsonOK("Insercion exitosa");
				}
				else
					$res = jsonErr("Relacion alumno escuela ya existente");

			}
			else
				$res = jsonErr("Alumno no existente");

		}
		else 
			$res = jsonErr("Error en parametros");
	}
	catch(PDOException $e){
		//$res = jsonErr($e->getMessage());
		$res = jsonErr($e->getMessage());
	}

	echo $res;
	}

//func = escuelaDeAlum_cu; params = cuAlum;
function escuelaDeAlum_cu(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from alumnos where cu = :cuAlum", 
									array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$alum = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $alum["idAlum"];
				$params = array("idAlum");
				$stmt = $msql->sqlPrepPost("SELECT e.nombre
					FROM alumnos a, alumnos_escuelas b, escuelasAlternas e 
					where a.idAlum = :idAlum and a.idAlum = b.idAlum and b.idEsc = e.idEsc", $params);

				$stmt->execute();
				$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$res = json( $row );

			}
			else
				$res = jsonErr("Alumno no existente");

		}
		else 
			$res = jsonErr("Error en parametros");
	}
	catch(PDOException $e){
		//$res = jsonErr($e->getMessage());
		$res = $e;
	}

	echo $res;
}

 ?>
