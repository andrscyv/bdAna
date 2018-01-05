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


}
?>