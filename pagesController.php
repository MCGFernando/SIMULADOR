<?php
require_once "conexao.php";
require_once "dao.php";
$c = connection::conectaSqlServerCligestsi();

$idEntidade = $_POST['idEntidade'];
$len = count($_POST['artigo']);

    $id = $_POST['idArtigo'];
    $artigo = $_POST['artigo'];
    $iva = $_POST['iva'];
    $precoArtigo = $_POST['precoArtigo'];
    $valorArtigo = $_POST['valorArtigo'];
    $semIVA = $_POST['semIVA'];
    $comIVA = $_POST['comIVA'];
    $processo = $_POST['numProcesso'];
    $tipoArtigo = isset($_POST['tipoArtigo'])?$_POST['tipoArtigo']:"";
    $dbTimeStamp = $_POST['dbTimeStamp'];
    $qnt = $_POST['qnt'];
    $estadoCRUD = false;
    $fes = dao::pesquisaFichaEpisodioUtente($processo);

if ($idEntidade == 416 || $idEntidade == 415) {
    include('pageADV.php');
} else {
    include('pageOthers.php');
}
?>