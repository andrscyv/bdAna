<?php /**
* 
*/
class bd
{	
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbName = "alumnoscompu";
	public $conn;
	
	function __construct()
	{
		try {
    $this->conn = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbName, $this->username, $this->password);
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