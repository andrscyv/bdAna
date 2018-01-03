<?php 

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=alumnoscompu", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 

    $stmt = $conn->prepare("SELECT * FROM alumnos"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	echo $row["nombre"];
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


 ?>