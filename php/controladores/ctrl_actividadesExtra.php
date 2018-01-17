<?php 



function insertaActividad(){
	global $msql;
	$conn = $msql->conn;
	
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from alumnos where cu = :cuAlum", 
									array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$alum = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $alum["idAlum"];
				$params = array("nombre", "tipo", "idAlum");
				$stmt = $msql->sqlPrepPost("INSERT INTO actividadesExtra(idAlum, nombre, tipo)
						VALUES (:idAlum, :nombre, :tipo)", $params);

				$stmt->execute();
				$idAct = $conn->lastInsertId();
				$res = json(array("idActividad" => $idAct));

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

function actividadesExtra(){
	global $msql;
	$res = $msql->cons("select * from actividadesExtra");
	echo json($res);
}




 ?>