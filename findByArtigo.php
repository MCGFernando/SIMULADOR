<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServer();
        $dados = array();
        $condicao =  $_POST["consulta"]; //"PRE NAN Pó lata 400 g";//;//'"ACTILAM Amp. bebíveis emb. de 20 de 10 ml"

        $sql = "SELECT Produto.[ID Produto], Produto.Produto, IVA.IVA, [Custo Unitário]*360*1.425 AS valorArtigo FROM Produto LEFT JOIN IVA ON Produto.[ID Produto] = IVA.[ID Acto] WHERE Produto = '".$condicao."'";
        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($result);
        foreach($result as $row){
            $dados[] = array(
                'IdActo' => str_ireplace($condicao, $replace_string, $row["ID Produto"]),
                'Acto' => str_ireplace($condicao, $replace_string, $row["Produto"]),
                'IVA' => str_ireplace($condicao, $replace_string, $row["IVA"]),
                'valorArtigo' => str_ireplace($condicao, $replace_string, $row["valorArtigo"]),
                'valorComArtigo' => $row["IVA"]==14 ? ($row["valorArtigo"] + ($row["valorArtigo"]*0.14)): $row["valorArtigo"]
            );
        }
        echo json_encode($dados);
    }
?>