<?php 

function insertaSancion(){


	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum","descripcion", "area", "problemasReglamento");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from alumnos where cu = :cuAlum", 
									array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$alum = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $alum["idAlum"];
				$params = array("descripcion", "area", "problemasReglamento", "idAlum");
				$stmt = $msql->sqlPrepPost("INSERT INTO sanciones(idAlum, descripcion,
						area, problemasReglamento)
						VALUES (:idAlum, :descripcion, :area, :problemasReglamento)", $params);

				$stmt->execute();
				$idSancion = $conn->lastInsertId();
				$res = json(array("idSancion" => $idSancion));

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

function sanciones(){
	global $msql;
	$res = $msql->cons("select * from sanciones");
	echo json($res);
}




 ?>