<?php
    require_once "conexao.php";
    $c = connection::conectaSqlServer();
    $pesquisa = $_GET['pesquisa'];
    $stmt = $c->prepare("SELECT * FROM Acto WHERE [Acto] LIKE '%".$pesquisa."%'");
    //$stmt->execute([$pesquisa]);
    $stmt->execute();
    echo "Linhas ".$stmt->rowCount();
    $result = $stmt->fetchAll();
    //var_dump($result);
    foreach($result as $row){
        echo $row['Acto']."<br>";
    }
?>