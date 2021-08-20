<?php
require_once "conexao.php";
    if(isset($_POST["consulta"])){
        $c = connection::conectaSqlServerCligestsi();
        $dados = array();
        $condicao = str_replace('\\', '\\\\',  $_POST["consulta"]);//$_POST["pesquisa"]"ACTILAM Amp. bebíveis emb. de 20 de 10 ml"

        $sql = "SELECT f.[Default EXT], f.[Default Utente], f.[ID entidade], f.[Nº de Processo], f.[ID Ficha de Episódio], f.[Data de Entrada] 
        FROM FE f INNER JOIN Marcação m ON f.[ID Ficha de Episódio] = m.[ID FE] WHERE (f.[Data de Entrada] = '".date("Y/m/d")."' AND m.Estado = 'EM CURSO') AND 
        (f.[Nº de Processo] LIKE '%".$condicao."%' OR f.[Default Utente] LIKE '%".$condicao."%' OR f.[Default EXT] LIKE '%".$condicao."%')";

        $result = $c->query($sql);
        $replace_string = $condicao;
        //var_dump($result);
        foreach($result as $row){
            $dados[] = array(
                'idUtente' => str_ireplace($condicao, $replace_string, $row["Default EXT"]),
                'utente' => str_ireplace($condicao, $replace_string, $row["Default Utente"]),
                'idEntidade' => str_ireplace($condicao, $replace_string, $row["ID entidade"]),
                'processo' => $row["Nº de Processo"],
                'idFE' => $row["ID Ficha de Episódio"],
                'dataEntrada' => $row["Data de Entrada"]
            );
        }
        echo json_encode($dados);
    }
?>