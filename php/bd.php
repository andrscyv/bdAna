<?php /**
* 
*/
class bd
{	
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $conn;
	
	function __construct()
	{
		try {
    $conn = new PDO("mysql:host=$servername;dbname=alumnoscompu", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 

   
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

	}

	function cons($str){
		$stmt = $conn->prepare($str); 
		$stmt->execute(); 
		$rows = $stmt->fetchAll();

		return $rows;
	}


}
?>