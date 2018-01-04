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



 ?>