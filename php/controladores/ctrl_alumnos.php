<?php 
//require 'bd.php';
//require 'util.php';
//$msql = new bd;

function alumnos(){
	global $msql;
	$res = $msql->cons('select * from alumnos');
	echo json($res);
}

function alumno_id(){
	global $msql;
	$conn = $msql->conn;
	if( isset( $_POST['id'] ) ){

		$id = $_POST['id'];
		$stmt = $conn->prepare("select * from alumnos where idAlum = :id");
		$stmt->bindParam(':id',$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

	echo json($res);

}

function alumno_cu(){
	global $msql;
	$conn = $msql->conn;
	if( isset( $_POST['cu'] ) ){

		$cu = $_POST['cu'];
		$stmt = $conn->prepare("select * from alumnos where cu = :cu");
		$stmt->bindParam(':cu',$cu);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

	echo json($res);
	//echo 'hola cu';

}

function insertaAlumno(){
	global $msql;
	$conn = $msql->conn;
	$params = array("cu", "beca", "nombre", "apellidoP", "apellidoM", "programa",
				"email", "telefono", "estado", "calle", "colonia", "delegacion", 
				"cp", "numExt", "numInt");
	
	try{
		if( issetArrPost( $params ) ){

			$stmt = $msql->sqlPrepPost("SELECT * from alumnos where cu = :cu", 
									array("cu"));
			$stmt->execute();

			if($stmt->rowCount() == 0){
				$stmt = $conn->prepare("INSERT INTO alumnos (cu, beca, nombre, apellidoP, apellidoM, programa,
								email, telefono, estado, calle, colonia, delegacion, cp, numExt, numInt)
								VALUES (:cu, :beca, :nombre, :apellidoP, :apellidoM, :programa,
								:email, :telefono, :estado, :calle, :colonia, :delegacion, :cp,
								:numExt, :numInt)");

				foreach ($params as $param )
					$stmt->bindParam(":".$param, $_POST[$param]);

				$stmt->execute();
				$res = jsonOk("exito");
			}
			else
				$res = jsonErr("alumno ya existente");
		}
		else
			$res = jsonErr("parametros insuficientes");
	}
	catch(PDOException $e){
		//$res = jsonErr($e->getMessage());
		$res = $e;
	}

	echo $res;
	//echo var_dump(issetArrPost($params));
}



 ?>