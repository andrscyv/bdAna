<?php 

function auth(){
	global $msql;
	$conn = $msql->conn;

	if(isset($_POST['usuario']) and isset($_POST['password'])){
		$usu = $_POST['usuario'];
		$psw = $_POST['password'];
		$stmt = $conn->prepare("SELECT * from usuarios where usuario =:usu and 
								password = :psw");
	    $stmt->bindParam(':usu', $usu);
	    $stmt->bindParam(':psw', $psw);
	    $stmt->execute();
	    if($stmt->rowCount() > 0)
	    	session_start();
	}

	//echo isset($_SESSION);
	echo 'sesion iniciada';
}


 ?>