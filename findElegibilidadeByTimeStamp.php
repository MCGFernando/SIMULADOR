<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServerCligestsi();
        $dados = array();
        $condicao =  $_POST["consulta"]; 
        $sql = "SELECT R.[actId], R.[actDescription], R.[IVA], R.[ProcCode], R.[CligestIdEpisode], R.[price], R.[date_request], R.[quantity]
        ,Q.[elegibilityNbr], Q.[AmtCoPay], Q.[AmtPaid], Q.[TotalIva], Q.[date_request]
        FROM ActsClinicRequest R LEFT JOIN  ActsClinicQueue Q ON R.CligestIdEpisode = Q.CligestIdEpisode
        WHERE R.date_request='".date('Y-m-d H:i:s',$condicao)."' AND Q.date_request='".date('Y-m-d H:i:s',$condicao)."' 
        AND R.ProcCode=Q.ProcCode
        GROUP BY R.[actId], R.[actDescription], R.[IVA], R.[ProcCode], R.[CligestIdEpisode], R.[price], R.[date_request], R.[quantity]
        ,Q.[elegibilityNbr]    ,Q.[AmtCoPay]    ,Q.[AmtPaid]    ,Q.[TotalIva]    ,Q.[date_request]";
        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($result);
        foreach($result as $row){
            $dados[] = array(
                'actDescription' => str_ireplace($condicao, $replace_string, $row["actDescription"]),
                'IVA' => str_ireplace($condicao, $replace_string, $row["IVA"]),
                'price' => str_ireplace($condicao, $replace_string, $row["price"]),
                'quantity' => str_ireplace($condicao, $replace_string, $row["quantity"]),
                'elegibilityNbr' => str_ireplace($condicao, $replace_string, $row["elegibilityNbr"]),
                'CligestIdEpisode' => str_ireplace($condicao, $replace_string, $row["CligestIdEpisode"]),
                'ProcCode' => str_ireplace($condicao, $replace_string, $row["ProcCode"]),
                'AmtCoPay' => str_ireplace($condicao, $replace_string, $row["AmtCoPay"]),
                'AmtPaid' => str_ireplace($condicao, $replace_string, $row["AmtPaid"]),
                'TotalIva' => str_ireplace($condicao, $replace_string, $row["TotalIva"])
            );
        }
        echo json_encode($dados);
    }
?>