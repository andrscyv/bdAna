<?php 

function auth(){
	global $msql;
	$conn = $msql->conn;

	if(isset($_POST['usuario']) and isset($_POST['password'])){
		$usu = $_POST['usuario'];
		//$psw = $_POST['password'];
		$psw = hash('sha256', $_POST['password']);
		$stmt = $conn->prepare("SELECT * from usuarios where usuario =:usu and password =:psw");
	    $stmt->bindParam(':usu', $usu);
	    $stmt->bindParam(':psw', $psw);
	    $stmt->execute();
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    if( $stmt->rowCount() > 0){

	    	$_SESSION['login'] = 'true';
				$_SESSION["rol"] = $row["rol"];
				
				$res = jsonOk("Acceso Exitoso");
	    }
	    else
	    	$res = jsonErr("Credenciales incorrectas");
	}
	else
		$res = jsonErr("Credenciales incompletas");

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
				$_POST["pswd"] = hash('sha256', $_POST["pswd"]);
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