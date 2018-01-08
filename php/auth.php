<?php 

function auth(){
	global $msql;
	$conn = $msql->conn;
	$res='ok';

	if(isset($_POST['usuario']) and isset($_POST['password'])){
		$usu = $_POST['usuario'];
		$psw = $_POST['password'];
		$stmt = $conn->prepare("SELECT * from usuarios where usuario =:usu");
	    $stmt->bindParam(':usu', $usu);
	    $stmt->execute();
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if( ($stmt->rowCount() > 0) and password_verify($psw, $row["password"]) ){

	    	$_SESSION['login'] = 'true';
	    	$_SESSION["rol"] = $row["rol"];
	    }
	    else
	    	$res = jsonErr("Credenciales incorrectas");
	}

	//echo isset($_SESSION);
	echo $res;
}

function logout(){
	session_destroy();
	echo 'logout';
}

function nuevoUsuario(){
	global $msql;
	$conn = $msql->conn;
	$params = array("nomUsu", "pswd","rol");
	
	try{
		if( issetArrPost( $params ) and $_SESSION["rol"] == "admin"){

			$stmt = $msql->sqlPrepPost("SELECT * from usuarios where usuario = :nomUsu", 
									array("nomUsu"));
			$stmt->execute();

			if($stmt->rowCount() == 0){
				$_POST["pswd"] = password_hash($_POST["pswd"], PASSWORD_DEFAULT);
				$stmt = $msql->sqlPrepPost("INSERT INTO usuarios(usuario, password, rol)
						VALUES (:nomUsu, :pswd, :rol)", $params);

				$stmt->execute();
				$stmt = $msql->sqlPrepPost("SELECT * from usuarios where usuario = :nomUsu", 
									array("nomUsu"));
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);;
				$res = jsonOk($row);

			}
			else
				$res = jsonErr("Usuario ya existe");

		}
		else 
			$res = jsonErr("Error en parametros o en permiso");
	}
	catch(PDOException $e){
		//$res = jsonErr($e->getMessage());
		$res = $e;
	}

	echo $res;
}


 ?>