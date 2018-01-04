<?php 
//require 'bd.php';
//require 'util.php';
//$msql = new bd;

function alumnos(){
	global $msql;
	$res = $msql->cons('select * from alumnos');
	return json($res);
}

function alumno_id($id){
	global $msql;
	$conn = $msql->conn;
	$id = limpia($id);
}



 ?>