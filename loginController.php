<?php
require_once "conexao.php";
require_once "dao.php";
$utilizador = $_POST['utilizador'];
$senha = $_POST['senha'];

echo $utilizador;
$operador = dao::pesquisaLogin($utilizador, $senha);

if($operador==null){
    header("Location: index.php");
    exit;
}
else{
    session_start();
    $_SESSION['operador'] = $operador;
    header("Location: home.html");
    exit;
}
?>