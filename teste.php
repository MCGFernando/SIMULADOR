<?php
require_once "conexao.php";
require_once "dao.php";


        $data = dao::pesquisaResumoFEOthers(1394711);
        foreach($data as $row)
                echo "Nº de Processo - ".$row['Nº de Processo'];



        //var_dump($data);

?>