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

 ?>