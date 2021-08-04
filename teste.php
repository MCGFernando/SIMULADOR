<?php
require_once "conexao.php";
require_once "dao.php";

echo    date("d/m/Y");
$fes = dao::pesquisaFichaEpisodio();

foreach ($fes as $row) { 
    echo "Aqui ". $row['Nº de Processo'];
}
echo Time();
?>