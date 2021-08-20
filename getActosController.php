<?php

require_once "conexao.php";
require_once "dao.php";
$fes = dao::pesquisaFichaEpisodio();
$id = $_POST['idArtigo'];
$dbTimeStamp = Time();





var_dump($fes);
echo "<br>";
var_dump($id);
echo "<br>";
echo $dbTimeStamp;

/* $len = count($_POST['artigo']);
$id = $_POST['idArtigo'];
$artigo = $_POST['artigo'];
$qnt = $_POST['qnt'];
$iva = $_POST['iva'];
$precoArtigo = $_POST['precoArtigo'];
$valorComArtigo = $_POST['valorComArtigo'];
$totalSemIva = 0;
$totalComIva = 0; */

?>