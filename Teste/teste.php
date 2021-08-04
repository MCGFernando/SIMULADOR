<?php
require_once "conexao.php";
$c = connection::conectaSqlServer();

$stmt = $c->prepare("select top 10 * from FE");
$stmt->execute();
$data = $stmt->fetchAll();
foreach ($data as $row){
    echo $row['Default EXT']." - conectado ao 100.37 <br>";
}    
?>
