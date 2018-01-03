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
	$arr = '_'.$_SERVER['REQUEST_METHOD'];
	global $$arr;
	//echo $$arr['msg'];

	foreach($$arr as $nom => $param) {
	    $$arr[$nom] = limpia($param);
	    //echo $$arr[$nom];
	}
}

 ?>