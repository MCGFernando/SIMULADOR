<?php
require_once "conexao.php";
    if(isset($_POST["numProcesso"])){
        $c = connection::conectaSqlServerCligestsi();
        $dados = array();
        $condicao =  $_POST["numProcesso"]; //"PRE NAN Pó lata 400 g";//;//'"ACTILAM Amp. bebíveis emb. de 20 de 10 ml"

        $sql = "SELECT f.[Default EXT], f.[Default Utente], f.[ID entidade], f.[Nº de Processo], f.[ID Ficha de Episódio], f.[Data de Entrada] 
         FROM FE f WHERE f.[Nº de Processo] = '".$condicao."'";
        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($sql);
        foreach($result as $row){
            $dados[] = array(
                'idUtente' => $row["Default EXT"],
                'utente' =>  $row["Default Utente"],
                'idEntidade' =>  $row["ID entidade"],
                'processo' => $row["Nº de Processo"],
                'idFE' => $row["ID Ficha de Episódio"],
                'dataEntrada' => $row["Data de Entrada"]
            );
        }
        echo json_encode($dados);
    }
?>