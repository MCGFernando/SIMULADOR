<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServer();
        $dados = array();
        $condicao =  preg_replace('/[^A-Za-z0-9\- ]/', '',  $_POST["consulta"]);//$_POST["pesquisa"]
        $sql = "SELECT TOP 10  Acto  FROM IVA WHERE Acto LIKE '%".$condicao."%' ORDER BY [Acto] ASC";
        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($result);
        foreach($result as $row){
            $dados[] = array(
                'Acto' => str_ireplace($condicao, $replace_string, $row["Acto"])
            );
        }
        echo json_encode($dados);
    }
?>