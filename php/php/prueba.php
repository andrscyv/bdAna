<?php 
require 'bd.php';

$msq = new bd;
$res = $msq->cons('select * from alumnos');
foreach ($res as $r) {
    echo $r['nombre'];
}

 ?>