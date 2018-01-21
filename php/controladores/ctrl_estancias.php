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




 ?>