<?php 

//FALTA PROBAR
//func = insertaMateria; params = cMateria, folio, numCreditos, nombre, semestre (int)
function insertaMateria(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cMateria", "folio", "numCreditos", "nombre", "semestre");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from materias where cMateria = :cMateria", 
									array("cMateria"));
			$stmt->execute();

			if($stmt->rowCount() == 0){

				$stmt = $msql->sqlPrepPost("INSERT INTO materias(cMateria, folio, 
						numCreditos, nombre, semestre)
						VALUES (:cMateria, :folio, :numCreditos, :nombre, :semestre)", $params);

				$stmt->execute();
				$idMateria = $conn->lastInsertId();
				$res = json(array("idMateria" => $idMateria));

			}
			else
				$res = jsonErr("Materia ya existe");

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

function materias(){

	global $msql;
	$res = $msql->cons("select * from materias");
	echo json($res);
}

//func = registraMatAlum; params = cuAlum, cMateria, estatusFin, calificacion;
function registraMatAlum(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum","cMateria", "estatusFin", "calificacion");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT idAlum, idMat FROM alumnos a, materias m 
									WHERE a.cu =:cuAlum AND m.cMateria = :cMateria",
									array("cuAlum", "cMateria"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $row["idAlum"];
				$_POST["idMat"] = $row["idMat"];

				$stmt = $msql->sqlPrepPost("SELECT idAlum, idMat FROM alumnos_materias 
									WHERE idAlum =:idAlum AND idMat = :idMat",
									array("idAlum", "idMat"));
				$stmt->execute();
				if($stmt->rowCount() == 0){

					$params = array("idAlum", "idMat", "estatusFin", "calificacion");
					$stmt = $msql->sqlPrepPost("INSERT INTO alumnos_materias(idAlum, idMat,
							estatusFin, calificacion)
							VALUES (:idAlum, :idMat, :estatusFin, :calificacion)", $params);

					$stmt->execute();
					$res = jsonOK("Insercion exitosa");
				}
				else
					$res = jsonErr("Relacion alumno materia ya existente");

			}
			else
				$res = jsonErr("Alumno o materia no existente");

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