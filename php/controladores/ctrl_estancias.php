<?php 


//func  = insertaUniversidad ; params = nomUni, nomPais;
function insertaUniversidad(){
	global $msql;
	$conn = $msql->conn;
	$params = array("nomUni", "nomPais");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from estancias where universidad = :nomUni 
										 and pais = :nomPais ", 
									array("nomUni", "nomPais"));
			$stmt->execute();

			if($stmt->rowCount() == 0){

				$stmt = $msql->sqlPrepPost("INSERT INTO estancias(universidad, pais)
						VALUES (:nomUni, :nomPais)", $params);

				$stmt->execute();
				$idUni = $conn->lastInsertId();
				$res = json(array("idUniversidad" => $idUni));

			}
			else
				$res = jsonErr("Universidad ya existe");

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

function universidades(){
	global $msql;
	$res = $msql->cons("select * from estancias");
	echo json($res);
}


//solo se puede registrar una estancia para un alumno y una 
//misma universidad
//
//func = registraEstanciaAlumno; params = cuAlum, idEst, anio(int), semestre(varchar)
function registraEstanciaAlumno(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum","idEst", "anio", "semestre");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT idAlum FROM alumnos WHERE cu =:cuAlum",
									array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $row["idAlum"];

				$stmt = $msql->sqlPrepPost("SELECT * FROM alumnos_estancias 
									WHERE idAlum =:idAlum AND idEst = :idEst",
									array("idAlum", "idEst"));
				$stmt->execute();
				if($stmt->rowCount() == 0){

					$params = array("idAlum", "idEst", "anio", "semestre");
					$stmt = $msql->sqlPrepPost("INSERT INTO alumnos_estancias(idAlum, idEst, 
							anio, semestre)
							VALUES (:idAlum, :idEst, :anio, :semestre)", $params);

					$stmt->execute();
					$res = jsonOK("Insercion exitosa");
				}
				else
					$res = jsonErr("Relacion alumno estancia ya existente");

			}
			else
				$res = jsonErr("Alumno o universidad no existente");

		}
		else 
			$res = jsonErr("Error en parametros");
	}
	catch(PDOException $e){
		//$res = jsonErr($e->getMessage());
		$res = jsonErr($e);
	}

	echo $res;
}




 ?>