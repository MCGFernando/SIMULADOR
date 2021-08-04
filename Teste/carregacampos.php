<?php
require_once "conexao.php";
//$myArray = [];
function actos(){
    $c = connection::conectaSqlServer();
    $idActo = 20;
    $stmt = $c->prepare("SELECT * FROM Acto WHERE [ID Acto] = ?");
    $stmt->execute([$idActo]);
    
    $act = $stmt->fetch();
    header("content-type:application/json");
    $myArray = json_encode($act) ;
    return $myArray;
}
actos();
/* array_push($myArray,actos());
array_push($myArray,actos());

//print_r($myArray);
foreach ($myArray as $actos){
    echo "<tr>";
    echo '<td><input type="text" name="tipoartigo" id="tipoartigo" value="' . $myArray[0][0]['ID Acto'] . '"readonly></td>';
    echo '<td><input type="text" name="tipoartigo" id="tipoartigo" value="' . $myArray[0][0]['Acto'] . '"readonly></td>';
    echo '<td><input type="text" name="tipoartigo" id="tipoartigo" value="' . $myArray[0][0]['ID Acto'] . '"readonly></td>';
    echo '<td><input type="text" name="tipoartigo" id="tipoartigo" value="' . $myArray[0][0]['ID Acto'] . '"readonly></td>';
    echo "</tr>";
}
 */
?>
