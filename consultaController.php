<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServer();
        $dados = array();
        $condicao =  preg_replace('/[^A-Za-z0-9\- ]/', '',  $_POST["consulta"]);//$_POST["pesquisa"]"ACTILAM Amp. bebíveis emb. de 20 de 10 ml"
        $sql = "SELECT TOP 10  Produto  FROM Produto WHERE Produto LIKE '%".$condicao."%' ORDER BY [Produto] ASC";
        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($result);
        foreach($result as $row){
            $dados[] = array(
                'Acto' =>  $row["Produto"]
            );
        }
        echo json_encode($dados);
    }
?>