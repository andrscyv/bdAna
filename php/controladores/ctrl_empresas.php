<?php 

//func = insertaEmpresa; params = rfc, telefono, estado, nombre, calle, colonia,
//	delegacion, cp(int), numExt (int), numInt(int), giro;
function insertaEmpresa(){

	global $msql;
	$conn = $msql->conn;
	$params = array("rfc", "telefono", "estado", "nombre", "calle", "colonia", "delegacion",
					"cp", "numExt", "numInt", "giro");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from empresas where rfc = :rfc", 
									array("rfc"));
			$stmt->execute();

			if($stmt->rowCount() == 0){

				$stmt = $msql->sqlPrepPost("INSERT INTO empresas(rfc, telefono, estado, nombre,
				 		calle, colonia, delegacion, cp, numExt, numInt, giro)
						VALUES (:rfc, :telefono, :estado, :nombre,
				 		:calle, :colonia, :delegacion, :cp, :numExt, :numInt, :giro)", $params);

				$stmt->execute();
				$idEmpresa = $conn->lastInsertId();
				$res = json(array("idEmpresa" => $idEmpresa));

			}
			else
				$res = jsonErr("Empresa ya existe");

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

function empresas(){
	global $msql;
	$res = $msql->cons("select * from empresas");
	echo json($res);
}

//func = registraAlumEmpresa_cu; params = cuAlum, rfc, puesto, fechaIni;

function registraAlumEmpresa_cu(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum","rfc", "puesto", "fechaIni");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT idAlum, idEmp FROM alumnos, empresas
				WHERE cu =:cuAlum and rfc = :rfc",
									array("cuAlum", "rfc"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $row["idAlum"];
				$_POST["idEmp"] = $row["idEmp"];

				$stmt = $msql->sqlPrepPost("SELECT * FROM alumnos_empresas 
									WHERE idAlum =:idAlum AND idEmp = :idEmp",
									array("idAlum", "idEmp"));
				$stmt->execute();
				if($stmt->rowCount() == 0){

					$params = array("idAlum", "idEmp", "puesto", "fechaIni");
					$stmt = $msql->sqlPrepPost("INSERT INTO alumnos_empresas(idAlum, idEmp, 
							puesto, fechaIni)
							VALUES (:idAlum, :idEmp, :puesto, :fechaIni)", $params);

					$stmt->execute();
					$res = jsonOK("Insercion exitosa");
				}
				else
					$res = jsonErr("Relacion alumno empresa ya existente");

			}
			else
				$res = jsonErr("Alumno o empresa no existente");

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

//func = empresaDeAlum_cu; params = cuAlum;
function empresaDeAlum_cu(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from alumnos  where cu = :cuAlum", 
									array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$alum = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $alum["idAlum"];
				$params = array("idAlum");
				$stmt = $msql->sqlPrepPost("SELECT e.rfc, e.telefono, e.estado, e.nombre,
				 		e.calle, e.colonia, e.delegacion, e.cp, e.numExt, e.numInt, e.giro
				 		 from alumnos a, alumnos_empresas b, empresas e
				 		 where a.idAlum = :idAlum and a.idAlum =b.idAlum and b.idEmp = e.idEmp", $params);

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