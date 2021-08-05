<?php
require_once "conexao.php";
require_once "dao.php";
try {
    $c = connection::conectaSqlServerCligestsi();

    $len = count($_POST['artigo']);

    $id = $_POST['idArtigo'];
    $artigo = $_POST['artigo'];
    $iva = $_POST['iva'];
    $precoArtigo = $_POST['precoArtigo'];
    $valorArtigo = $_POST['valorArtigo'];
    $semIVA = $_POST['semIVA'];
    $comIVA = $_POST['comIVA'];
    $processo = $_POST['numProcesso'];
    $tipoArtigo = $_POST['tipoArtigo'];
    $dbTimeStamp = $_POST['dbTimeStamp'];
    $qnt = $_POST['qnt'];
    $estadoCRUD = false;

    $conta = dao::pesquisaProdutoRequestPorTimestamp($dbTimeStamp);
    echo $conta;
    if ($conta == 0) {
        for ($i = 0; $i < $len; $i++) {
            $codeiva = determinaProcCode($tipoArtigo, $iva[$i]);
            $sql = "INSERT INTO ActsClinicRequest (actId, actDescription, IVA, ProcCode, CligestIdEpisode, price, date_request, quantity) 
        VALUES (" . $id[$i] . ", '" . $artigo[$i] . "', " . $iva[$i] . ", '" . $codeiva . "', '" . $processo . "', " . $precoArtigo[$i] . ", '" . date('Y-m-d H:i:s', $dbTimeStamp) . "'," . $qnt[$i] . ")";
            //echo $sql . "<br>";
            $stmt = $c->prepare($sql);
            $estadoCRUD = $stmt->execute();
        }
    } else {
        $estadoCRUD = true;
        echo 'Registo ja cadastrado';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

function determinaProcCode($tipo, $ivaCode)
{

    switch ($tipo) {
        case 'CONSUMIVEIS':
            return  $ivaCode == 14 ? "98100000PC" : "98100001PC";
        case 'FARMACOS':
            return  $ivaCode == 14 ? "98100000PF" : "98100001PF";
        case 'FARMACIA EXTERNA':
            return  $ivaCode == 14 ? "PF99999990" : "PF99999999";
        default:
            return  "98100001VC";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Cligest - Simulador de Elegibilidades Clínicas</title>
</head>

<body>
    <div class="container">
        <?php if ($estadoCRUD) { ?>
            <h4>Para finalizar, crie no <a href="https://cligest-ar-quality.azurewebsites.net/" target="blank">WS</a> uma Elegibilidade com as seguintes artigos:</h4><br><br>
            <label for=""><?php echo $tipoArtigo ?> Sem Iva.: </label><input type="text" name="" id="semIVA" class="form-control" value="<?php echo $semIVA ?>" readonly>
            <label for=""><?php echo $tipoArtigo ?> Com Iva.: </label><input type="text" name="" id="comIVA" class="form-control" value="<?php echo $comIVA ?>" readonly>
            <input type="hidden" name="consulta" id="consulta" value="<?php echo $dbTimeStamp ?>" readonly>
            <br><br>
            <h4>Após criar a Elegibilidade, volte para esta página e pressione o Botão Finalizar </h4>
            <hr>
            <button class="btn btn-success" onclick="javascript:mostraResumoFinal()">Finalizar</button>
            <div style="display: none;" id="startHidden">
                <h2>Resumo da Simulação</h2>
            </div>

        <?php } else { ?>
            <h2>Por alguma razão não foi possível concluir a simulação. Por favor chame o Administrador</h2>
        <?php } ?>
    </div>

    <script>
        function mostraResumoFinal() {
            event.preventDefault()
            var form_data = new FormData()
            form_data.append('consulta', consulta.value)

            var ajaxRequest = new XMLHttpRequest()
            ajaxRequest.open('POST', 'findElegibilidadeByTimeStamp.php')
            ajaxRequest.send(form_data)
            ajaxRequest.onreadystatechange = function() {
                if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    console.log('Consulta aqi ' + ajaxRequest.responseText)
                    var resposta = JSON.parse(ajaxRequest.responseText)
                    console.log('Resposta ' + resposta)
                    console.log('Resposta Size ' + resposta.length)
                    console.log('Consulta ' + consulta.value)

                    if (resposta.length > 0) {
                        console.log('i - ' + JSON.stringify(resposta))
                        //console.log('Consulta ' + resposta[i].elegibilityNbr)
                        document.getElementById('startHidden').style.display = "block"
                        var p = document.createElement('p')
                        p.innerHTML = JSON.stringify(resposta)
                        document.getElementById('startHidden').appendChild(p)
                    } else {
                        alert("Desculpa. Houve algum problema")
                    }
                }
            }
        }
    </script>
</body>

</html>