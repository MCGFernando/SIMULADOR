<?php
require_once "conexao.php";
require_once "dao.php";
$c = connection::conectaSqlServerCligestsi();

session_start();
$len = count($_SESSION['idArtigo']);
$id = $_SESSION['idArtigo'];
$qnt = $_SESSION['qnt'];
$valorComArtigo = $_SESSION['valorComArtigo'];
$operador = $_SESSION['operador'];


$utente = $_POST['utente'];
$idUtente = $_POST['idUtente'];
$dataEntrada = $_POST['dataEntrada'];
$idFe = $_POST['idFe'];

$medicamentosComIVA = $_POST['medicamentosComIVA'];
echo "medicamentosComIVA " . $medicamentosComIVA;
$medicamentosSemIVA = $_POST['medicamentosSemIVA'];
echo "<br>medicamentosSemIVA " . $medicamentosSemIVA;

$guia = $_POST['guia'];
$valorTotalGuiaIVA = $_POST['valorTotalGuiaIVA'];
echo "<br>valorTotalGuiaIVA " . $valorTotalGuiaIVA;
$copamentoIVA = $_POST['copamentoIVA'];
//echo "<br>copamentoIVA ".$copamentoIVA;

$guiaIVA = $_POST['guiaIVA'];
//echo "<br>guiaIVA ".$guiaIVA;
$valorTotalGuia = $_POST['valorTotalGuia'];
//echo "<br>valorTotalGuia ".$valorTotalGuia;
$copamento = $_POST['copamento'];
//echo "<br>copamento ".$copamento;


/* for ($i = 0; $i < $len; $i++){
    echo "<br>Iteracao ".$i;
    $producto = dao::pesquisaProducto($id[$i]);
    echo "<br>Preco ".$producto[0]['Preço Unitário AKZ'];
    echo "<br>Custo ".$producto[0]['Custo Unitário'];
    echo "<br>IVA ".$producto[0]['IVA'];
    echo "<br>ValorArtigo ".$valorComArtigo[$i];
    echo "<br>quantidade ".$qnt[$i];
} */
for ($i = 0; $i < $len; $i++) {
    //echo "<br>ID Artigo : " . $id[$i];
    $producto = dao::pesquisaProducto($id[$i]);
    //var_dump($producto);
    //echo "<br>ID Artigo : " . $id[$i]." - ".$producto[0]['Produto'];
    $idRegistoFE = dao::pesquisaMaxIDFE();
    $idRegistoFE[0]['idRegisto']++;
    $percentual = 0;
    $diferencial = 0;
    $novoCoef = 0;
    $novoValorAKZ = 0;
    $novoPrecoAKZ = 0;
    $novoPUAKZ = 0;
    $novoCopagamento = 0;
    if ($producto[0]['IVA'] == 14) {

        $diferencial = $medicamentosComIVA - ($valorTotalGuiaIVA);
        echo "<br>diferencial " . $diferencial;
        $percentual = $diferencial / $medicamentosComIVA;
        echo "<br>percentual " . $percentual;
        $novoCoef = $copamentoIVA / $valorComArtigo[$i];
        echo "<br>novoCoef " . $novoCoef;
        $novoValorAKZ = $valorComArtigo[$i] - ($valorComArtigo[$i] * $percentual);
        echo "<br>novoValorAKZ " . $novoValorAKZ;
        $novoPrecoAKZ = $producto[0]['Preço Unitário AKZ'] - ($producto[0]['Preço Unitário AKZ'] * $percentual);
        echo "<br>novoPrecoAKZ " . $novoPrecoAKZ;
        $novoPUAKZ = $producto[0]['Custo Unitário'] - ($producto[0]['Custo Unitário'] * $percentual);
        echo "<br>novoPUAKZ " . $novoPUAKZ;
        $novoCopagamento = $valorComArtigo[$i] - $novoValorAKZ;
    } else {

        $diferencial = $medicamentosSemIVA - ($valorTotalGuia);
        echo "<br>diferencial " . $diferencial;
        $percentual = $diferencial / $medicamentosSemIVA;
        echo "<br>percentual " . $percentual;
        $novoCoef = $copamento / $valorComArtigo[$i];
        echo "<br>novoCoef " . $novoCoef;
        $novoValorAKZ = $valorComArtigo[$i] - ($valorComArtigo[$i] * $percentual);
        echo "<br>novoValorAKZ " . $novoValorAKZ;
        $novoPrecoAKZ = $producto[0]['Preço Unitário AKZ'] - ($producto[0]['Preço Unitário AKZ'] * $percentual);
        echo "<br>novoPrecoAKZ " . $novoPrecoAKZ;
        $novoPUAKZ = $producto[0]['Custo Unitário'] - ($producto[0]['Custo Unitário'] * $percentual);
        echo "<br>novoPUAKZ " . $novoPUAKZ;
        $novoCopagamento = $valorComArtigo[$i] - $novoValorAKZ;
    }

    $sql = "INSERT INTO [Registo FE] ([ID Registo], [ID Utente], [Cod Utente], [ID Acto], Acto, [ID FE], Classe, DataRegisto, Ordem , Coef, [Valor AKZ], 
    Elegibilidade, DataElegibilidade, Operador, Copagamento, IVA, [Preco AKZ], [PU AKZ], Qtd) VALUES (" . $idRegistoFE[0]['idRegisto'] . ", '" . $utente . "', 
    " . $idUtente . ", " . $producto[0]['ID Produto'] . ", '" . $producto[0]['Produto'] . "', " . $idFe . ", " . "'MEDICAMENTOS'" . ", '" . $dataEntrada . "', 100, 
    " . $novoCoef . ", " . $novoValorAKZ . ", '" . $guia . "', '" . $dataEntrada  . "', " . $operador[0]['ID_User'] . ", " . $novoCopagamento . ", " . $producto[0]['IVA'] . ",
     " . $novoPrecoAKZ . ", " . $novoPUAKZ . ", " . $qnt[$i] . ")";

    echo "<br>" . $sql;
    $stmt = $c->prepare($sql);
    $estadoCRUD = $stmt->execute(); 

    if ($estadoCRUD) {
        echo 'Cadastrado';
    } else {
        echo 'Nao Cadastrado';
    }
}

if ($estadoCRUD) {    
    $feRegisto = dao::pesquisaResumoFEOthers($idFe);
    $_SESSION['feRegisto'] = $feRegisto;
    //var_dump($feRegisto);
    header("Location: pageResumoOthers.php");
    exit;
} else {
    echo 'Ocorreu algum erro. Por favor Chame o Administrador';
}
echo "<br>Terminou";
