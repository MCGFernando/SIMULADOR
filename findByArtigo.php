<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServer();
        $dados = array();
        $condicao =  $_POST["consulta"];//'"ARTEMETHER (ARtesIANE) 80MG/ML C/ 05 AMP"

        $sql = "SELECT [ID Acto], Acto, IVA  FROM IVA WHERE Acto = '".$condicao."'";
        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($result);
        foreach($result as $row){
            $dados[] = array(
                'IdActo' => str_ireplace($condicao, $replace_string, $row["ID Acto"]),
                'Acto' => str_ireplace($condicao, $replace_string, $row["Acto"]),
                'IVA' => str_ireplace($condicao, $replace_string, $row["IVA"])
            );
        }
        echo json_encode($dados);
    }
?>