<?php 

//func = insertaComentCu; params = cuAlum, comentario
function insertaComentCu(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cuAlum","comentario");
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from alumnos where cu = :cuAlum", 
									array("cuAlum"));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$alum = $stmt->fetch(PDO::FETCH_ASSOC);
				$_POST["idAlum"] = $alum["idAlum"];
				$params = array("comentario", "idAlum");
				$stmt = $msql->sqlPrepPost("INSERT INTO comentarios(idAlum, comentario)
						VALUES (:idAlum, :comentario)", $params);

				$stmt->execute();
				$idComm = $conn->lastInsertId();
				$res = json(array("idComentario" => $idComm));

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


function comentarios(){
	global $msql;
	$res = $msql->cons("select * from comentarios");
	echo json($res);
}

//func = comentarios_cu ; params = cuAlum
function comentarios_cu(){

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
				$stmt = $msql->sqlPrepPost("select * from comentarios
												where idAlum = :idAlum", $params);

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