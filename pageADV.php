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
    $fes = dao::pesquisaFichaEpisodioUtente($processo);
    $conta = dao::pesquisaProdutoRequestPorTimestamp($dbTimeStamp);
    //echo $conta;
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
        //echo 'Registo ja cadastrado';
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
<?php include('navbar.html');?>
    <div class="container">
        <?php if ($estadoCRUD ) { //$estadoCRUD 
        ?>
            <div id="startShowing">
                <h4>Crie no <a href="https://cligest-ar-quality.azurewebsites.net/" target="blank" class="badge badge-primary">WS</a> uma Elegibilidade com as seguintes artigos:</h4><br><br>
                <label for="">Utente.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $fes[0]['Default Utente'] ?>" readonly>
                <label for="">Ficha de Episódio.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $processo ?>" readonly>
                <label for=""><?php echo $tipoArtigo ?> Sem Iva.: </label>
                <div class="input-group mb-2" style="width: 200px;">
                    
                    <input type="text" name="" id="semIVA" style="text-align: right;" class="form-control form-control-lg" value="<?php echo number_format($semIVA, 2, '.', '') ?>" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-success" onclick="javascript:copiaSemIVA()">Copiar</button>
                    </div>
                </div>
                <label for=""><?php echo $tipoArtigo ?> Com Iva.: </label>
                <div class="input-group mb-2" style="width: 200px;">
                    
                    <input type="text" name="" id="comIVA" style="text-align: right;" class="form-control  form-control-lg" value="<?php echo  number_format($comIVA, 2, '.', '') ?>" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-success" onclick="javascript:copiaComIVA()">Copiar</button>
                        
                    </div>
                </div>
                <?php 
                    $date = date_create($fes[0]['Data de Entrada']);
                ?>
                <label for="">Data.: </label><input type="text" name="" id="" class="form-control" value="<?php echo date_format($date, "Y-m-d H:i:s") ?>" readonly>
                <input type="hidden" name="consulta" id="consulta" value="<?php echo $dbTimeStamp ?>" readonly>
                <br><br>
                <h4>Após criar a Elegibilidade, regresse a esta página e pressione o Botão Finalizar </h4>
                <hr>
                <button class="btn btn-success" onclick="javascript:mostraResumoFinal()">Finalizar</button>
            </div>


            <div style="display: none;" id="startHidden" class="container">
                <h2>Resumo da Simulação</h2>
                <div class="card-body">
                <label for="">Utente.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $fes[0]['Default Utente'] ?>" readonly>
                    <label for="">Elegibilidade</label>
                    <input type="text" name="" id="elegibilidade" class="form-control" value="" readonly>
                    <label for="">Ficha de Episódio</label>
                    <input type="text" name="" id="fe" class="form-control" value="" readonly>
                    <label for="">Data.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $fes[0]['Data de Entrada'] ?>" readonly>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>% Co-Pago</th>
                                <th>IVA (14%)</th>
                                <th>QNT</th>
                                <th>Valor</th>
                                <th>Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">

                        </tbody>
                    </table>

                    <hr>
                    <a href="home.html" class="btn btn-primary">Fazer Nova Simulação</a>
                </div>
            </div>

        <?php } else { ?>
            <h2>Por alguma razão não foi possível concluir a simulação. Por favor chame o Administrador</h2>
            <a href="home.html" class="btn btn-primary">Voltar a página inicial</a>
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
                    var total = 0
                    var resposta = JSON.parse(ajaxRequest.responseText)
                    console.log('Resposta ' + resposta)
                    console.log('Resposta Size ' + resposta.length)
                    console.log('Consulta ' + consulta.value)

                    if (resposta.length > 0) {
                        document.getElementById('startHidden').style.display = "block"
                        document.getElementById('startShowing').style.display = "none"

                        document.getElementById('elegibilidade').value = resposta[0].elegibilityNbr
                        document.getElementById('fe').value = resposta[0].CligestIdEpisode

                        var tr = document.createElement('tr')
                        var td = document.createElement('td')
                        td.setAttribute("style", " font-weight: bold;")
                        td.innerHTML = "Artigos Sem IVA"
                        tr.appendChild(td)
                        document.getElementById('tableBody').appendChild(tr)
                        for (let i = 0; i < resposta.length; i++) {
                            var elementType = 'tr'
                            if (resposta[i].IVA != 14) {
                                var tr = document.createElement('tr')
                                var td = document.createElement('td')
                                td.innerHTML = resposta[i].actDescription
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].AmtCoPay).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].TotalIva).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].quantity).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].price).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number((resposta[i].quantity*resposta[i].price)).toFixed(2)
                                total += resposta[i].quantity*resposta[i].price
                                tr.appendChild(td)
                                document.getElementById('tableBody').appendChild(tr)
                            }

                        }

                        var tr = document.createElement('tr')
                        var td = document.createElement('td')
                        td.setAttribute("style", " font-weight: bold;")
                        td.innerHTML = "Artigos Com IVA"

                        tr.appendChild(td)
                        document.getElementById('tableBody').appendChild(tr)
                        for (let i = 0; i < resposta.length; i++) {
                            var elementType = 'tr'
                            if (resposta[i].IVA == 14) {
                                var tr = document.createElement('tr')
                                var td = document.createElement('td')
                                td.innerHTML = resposta[i].actDescription
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].AmtCoPay).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(((resposta[i].price *resposta[i].quantity)*0.14)).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].quantity).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number(resposta[i].price).toFixed(2)
                                tr.appendChild(td)
                                var td = document.createElement('td')
                                td.innerHTML = Number((resposta[i].quantity*resposta[i].price)  + ((resposta[ i].price *resposta[i].quantity)*0.14)).toFixed(2)
                                total += (resposta[i].quantity*resposta[i].price)  + ((resposta[i].price *resposta[i].quantity)*0.14)
                                tr.appendChild(td)
                                document.getElementById('tableBody').appendChild(tr)
                            }
                        
                        }
                        var tr = document.createElement('tr')
                        var td = document.createElement('td')
                        tr.appendChild(td)
                        var td = document.createElement('td')
                        tr.appendChild(td)
                        var td = document.createElement('td')
                        tr.appendChild(td)
                        var td = document.createElement('td')
                        tr.appendChild(td)
                        var td = document.createElement('td')
                        td.setAttribute("style", " font-weight: bold;")
                        td.innerHTML = "Total"
                        tr.appendChild(td)
                        var td = document.createElement('td')
                        td.innerHTML = Number(total).toFixed(2)
                        tr.appendChild(td)
                        document.getElementById('tableBody').appendChild(tr)
                    } else {
                        alert("Desculpa. Ainda não recebemos resposta da Base de dados para a Elegibilidade que criou, por favor aguarde.\nSe o problema persistir chame o Administrador")
                    }
                }
            }
        }

        function adicionaElementos(parent, type, min, step, nameElement, classElement, valueElement, read) {
            var tableBody = document.getElementById('tableBody')

            var elementType = 'td'
            var td = criaElemento(elementType)
            var elementType = 'input'

            var attributes = [{
                    name: 'type',
                    value: type
                }, {
                    name: 'min',
                    value: min
                }, {
                    name: 'step',
                    value: step
                },
                {
                    name: 'name',
                    value: nameElement
                },
                {
                    name: 'class',
                    value: classElement
                },
                {
                    name: 'value',
                    value: valueElement
                }, {
                    name: 'readonly',
                    value: read
                }, {
                    name: 'form',
                    value: 'formSbumit'
                }
            ]
            if (type == "number" || type == "button") {
                attributes.splice(6, 1)
            }

            if (type == "button") {
                btnIndex++
                attributes.push({
                    name: 'onclick',
                    value: "removerRow(this)"
                })
            }

            var input = criaElemento(elementType, attributes)
            td.appendChild(input)
            parent.appendChild(td)

        }
        function copiaSemIVA(){
            event.preventDefault()
            var copiaTexto = document.getElementById("semIVA")
            copiaTexto.select()
            copiaTexto.setSelectionRange(0, 99999)
            document.execCommand("copy")
            //alert('copio')
        }
        function copiaComIVA(){
            event.preventDefault()
            var copiaTexto = document.getElementById("comIVA")
            copiaTexto.select()
            copiaTexto.setSelectionRange(0, 99999)
            document.execCommand("copy")
            //alert('copio')
        }
    </script>
</body>

</html>