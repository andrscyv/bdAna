<?php 

function json($arr){
	header('Content-Type: application/json');
	return json_encode($arr, JSON_FORCE_OBJECT);
}

function limpia($data){
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);

  	return $data;
}

function limpiaParams(){
	echo $_SERVER['REQUEST_METHOD'];
}

 ?>