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

function estancias(){
	global $msql;
	$res = $msql->cons("select cu, anio, semestre, universidad from 
		alumnos a, alumnos_estancias b, estancias e where a.idAlum = b.idAlum
		and b.idEst = e.idEst");
	echo json($res);
}


//func = materiasDeAlum_cu; params = cuAlum; //Regresa materias revalidadas en todos los intercambios
//del alumno;

function materiasDeAlum_cu(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("
				SELECT materiaRev, materiaItam, calificacion, anio, semestre, universidad
				 from alumnos a, alumnos_estancias b, estancias e, materiasRevalidadas m 
				where cu = :cuAlum and a.idAlum = b.idAlum and b.idEst = e.idEst and b.idInter = m.idInter", 
									array("cuAlum"));
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$res = json( $row );

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

//func = registraMateriaRev_cu; params = cuAlum, universidad, anio(int), semestre(string), materiaRev, 
//materiaItam , calificacion;
function registraMateriaRev_cu(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum", "universidad","anio", "semestre", 
				"materiaRev", "materiaItam", "calificacion");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT idInter FROM alumnos a, alumnos_estancias b,
					estancias e WHERE cu =:cuAlum and a.idAlum = b.idAlum and b.idEst = e.idEst 
					and universidad = :universidad and anio = :anio and semestre = :semestre",
									array("cuAlum", "universidad", "anio", "semestre"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idInter"] = $row["idInter"];

				$stmt = $msql->sqlPrepPost("SELECT * FROM materiasRevalidadas 
									WHERE idInter =:idInter AND materiaRev = :materiaRev",
									array("idInter", "materiaRev"));
				$stmt->execute();
				if($stmt->rowCount() == 0){

					$params = array("materiaRev", "materiaItam", "calificacion","idInter");
					$stmt = $msql->sqlPrepPost("INSERT INTO materiasRevalidadas(materiaRev, 
							materiaItam, calificacion, idInter)
							VALUES (:materiaRev, :materiaItam, :calificacion, :idInter)", $params);

					$stmt->execute();
					$res = jsonOK("Insercion exitosa");
				}
				else
					$res = jsonErr("Materia ya existente");

			}
			else
				$res = jsonErr("No se encontro registro de estancia");

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


 ?>