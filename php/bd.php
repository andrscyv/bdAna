<?php /**
* 
*/
class bd
{	
	public $conn;
	
	function __construct($config)
	{
		try {
    $this->conn = new PDO("mysql:host=".$config["servername"].";dbname=".$config["dbName"],
    						 $config["username"], $config["password"]);
    // set the PDO error mode to exception
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 

   
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

	}

	function cons($str){
		$stmt = $this->conn->prepare($str); 
		$stmt->execute(); 
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	function bindParamArrPost($stmt, $params){
		foreach ($params as $param )
					$stmt->bindParam(":".$param, $_POST[$param]);
	}

	//Prepara una instruccion sql con placeholder de la forma
	// :nomVar , donde nomVar es el nombre del parametro POST
	function sqlPrepPost($sql, $params){
		$connec = $this->conn;

		$stmt = $connec->prepare($sql);

		$this->bindParamArrPost($stmt, $params);
		

		return $stmt;
		}




}
?>