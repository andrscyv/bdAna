<?php 

function auth(){
	global $msql;
	$conn = $msql->conn;
	$res='ok';

	if(isset($_POST['usuario']) and isset($_POST['password'])){
		$usu = $_POST['usuario'];
		$psw = $_POST['password'];
		$stmt = $conn->prepare("SELECT * from usuarios where usuario =:usu and 
								password = :psw");
	    $stmt->bindParam(':usu', $usu);
	    $stmt->bindParam(':psw', $psw);
	    $stmt->execute();
	    if($stmt->rowCount() > 0){
	    	$_SESSION['login'] = 'true';
	    }
	    else
	    	$res = 'error';
	}

	//echo isset($_SESSION);
	echo $res;
}

function logout(){
	session_destroy();
	echo 'logout';
}




 ?>