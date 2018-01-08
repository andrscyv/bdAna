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

function jsonErr($msg){
	header('Content-Type: application/json');
	return json_encode(array('error' => $msg));
}

function jsonOk($msg){
	return json(array("ok" => $msg));
}

function issetArrPost($arr){
	$res = true;
	$i = 0;

	while( $i < count($arr) ){
		$res = ( $res and isset($_POST[$arr[$i]]) );
		$i++;
	}

	return $res;
	//return 'hola isset ';
}

 ?>