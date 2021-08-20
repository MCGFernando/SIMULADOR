<?php
require_once "conexao.php";
require_once "dao.php";
$c = connection::conectaSqlServerCligestsi();

$idEntidade = $_POST['idEntidade'];


if ($idEntidade == 416 || $idEntidade == 415) {
    include('pageADV.php');
} else {
    include('pageOthers.php');
}
?>