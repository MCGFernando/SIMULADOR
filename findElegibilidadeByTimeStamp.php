<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServerCligestsi();
        $dados = array();
        $condicao =  $_POST["consulta"]; 

        $sql = "SELECT * FROM ActsClinicQueue WHERE [date_request] = '".date('Y-m-d H:i:s',$condicao)."'";// WHERE CligestIdEpisode=? AND actId IN($placeholders)
        $result = $c->query($sql);
        $replace_string = $condicao;
        
        foreach($result as $row){
            $dados[] = array(
                'elegibilityNbr' => str_ireplace($condicao, $replace_string, $row["elegibilityNbr"]),
                'CligestIdEpisode' => str_ireplace($condicao, $replace_string, $row["CligestIdEpisode"]),
                'ProcCode' => str_ireplace($condicao, $replace_string, $row["ProcCode"]),
                'AmtClaimed' => str_ireplace($condicao, $replace_string, $row["AmtClaimed"]),
                'AmtCoPay' => str_ireplace($condicao, $replace_string, $row["AmtCoPay"]),
                'AmtPaid' => str_ireplace($condicao, $replace_string, $row["AmtPaid"]),
                'TotalIva' => str_ireplace($condicao, $replace_string, $row["TotalIva"])
            );
        }
        echo json_encode($dados);
    }
?>