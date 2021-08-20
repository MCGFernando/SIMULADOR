<?php
/* echo "Artigo" . count($_POST['artigo']) . "<br>";
    print_r($_POST['artigo']);
    echo "<br>ID Artigo" . count($_POST['idArtigo']) . "<br>";
    print_r($_POST['idArtigo'])."<br>";
    echo "<br>Valor Artigo" . count($_POST['valorArtigo']) . "<br>";
    print_r($_POST['valorArtigo'])."<br>";
    $len = count($_POST['artigo']);
    for($i=0; $i<$len;$i++){
       echo $_POST['artigo'][$i] . " - ". $_POST['idArtigo'][$i]  . " - ". $_POST['valorArtigo'][$i];
    }
 */
require_once "conexao.php";
require_once "dao.php";
$fes = dao::pesquisaFichaEpisodio();
$len = count($_POST['artigo']);
$id = $_POST['idArtigo'];
$artigo = $_POST['artigo'];
$qnt = $_POST['qnt'];
$iva = $_POST['iva'];
$precoArtigo = $_POST['precoArtigo'];
$valorComArtigo = $_POST['valorComArtigo'];
$totalSemIva = 0;
$totalComIva = 0;
$dbTimeStamp = Time();


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
        <h2 class="text-center mt-4 mb-4">Simulador de Elegibilidades Clínicas</h2>
        <!--<div class="row mt-5 mb-5" id="no-principal">
            <div class="col col-sm-2">&nbsp;</div>
            <div class="col col-sm-8">
                <div class="input-group mb-3">
                    <input type="text" name="consulta" id="consulta" class="form-control form-control-lg"
                        placeholder="Digite o [ID Utente] ou [Nome do Utente] ou [Nº do ECV]" onkeyup="javascript:carregaDados(this.value)">
                </div>
                <span id="resultado"></span>
            </div>
        </div>
        <hr>-->
        insercaoController
        
        <form action="pagesController.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ARTIGO</th>
                        <th>QNT</th>
                        <th style="display: none;">COPAY</th>
                        <th>CODE IVA</th>
                        <th>PREÇO ARTIGO</th>
                        <th>VALOR ARTIGO</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    for ($i = 0; $i < $len; $i++) {
                        if ($iva[$i] == 14) {
                            $totalComIva += $precoArtigo[$i] * $qnt[$i];
                        } else {
                            $totalSemIva += $precoArtigo[$i] * $qnt[$i];
                        }
                    ?>
                        <tr>
                            <td><input type="text" name="idArtigo[]" id="idArtigo" class="form-control" value="<?php echo $id[$i] ?>" style="width: 100px; text-align: right;" readonly></td>
                            <td><input type="text" name="artigo[]" id="artigo" class="form-control" value="<?php echo $artigo[$i] ?>" style="width: 400px;" readonly></td>
                            <td><input type="number" name="qnt[]" id="qnt" class="form-control" value="<?php echo $qnt[$i] ?>" style="width: 100px; text-align: right;"></td>
                            <td style="display: none;"><input type="number" name="" id="" class="form-control" value="" style="width: 100px; text-align: right;"></td>
                            <input type="hidden" name="iva[]" id="iva" value="<?php echo $iva[$i] ?>">
                            <td><input type="text" name="" id="" class="form-control" value="<?php echo ($iva[$i] == 14 ? "Artigo com IVA" : "Artigo sem IVA") ?>" readonly></td>
                            <td><input type="text" name="precoArtigo[]" id="precoArtigo" class="form-control" value="<?php echo $precoArtigo[$i] ?>" style="width: 100px;text-align: right;" readonly></td>
                            <td><input type="text" name="valorArtigo[]" id="valorArtigo" class="form-control" value="<?php echo $precoArtigo[$i] * $qnt[$i] ?>" style="width: 100px;text-align: right;" readonly></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <div class="form-group">
                <label for="numProcesso">1 - Passo) Selecione a Ficha de Episódio:</label>
                <select class="form-control" name="numProcesso" id="numProcesso" onchange="preenchCampos()" require>
                    <option value="0" disabled selected>Selcione a Ficha de Episódio</option>
                    <?php foreach ($fes as $row) { ?>
                        <option value="<?php echo $row['Nº de Processo'] ?>" data-entidade="<?php echo $row['ID entidade'] ?>"><?php echo $row['Nº de Processo'] ?></option>
                    <?php } ?>
                </select>
            </div>



            <div style="display: none;" id="startHidden">
                <div class="form-group">
                    <label for="tipoArtigo">Tipo de Artigo</label>
                    <select class="form-control" name="tipoArtigo" id="tipoArtigo" require>
                        <option value="0" disabled selected>Selcione o Tipo de Artigo</option>
                        <option value="CONSUMIVEIS">CONSUMIVEIS</option>
                        <option value="FARMACOS">FARMACOS</option>
                        <option value="FARMACIA EXTERNA">FARMACIA EXTERNA</option>
                        <option value="VACINAS">VACINAS</option>
                    </select>
                </div>
            </div>

            
            <hr>
            <label>ID Utente.: </label>
            <input type="text" name="" id="idUtente" class="form-control form-control-lg" value="" readonly>

            <label>Utente.: </label>
            <input type="text" name="" id="utente" class="form-control form-control-lg" value="" readonly>

            
            <input type="hidden" name="idEntidade" id="idEntidade" value="" readonly>

            <label>Total de Artigos Sem Iva.: </label>
            <input type="text" name="semIVA" id="semIVA" style="width: 200px; text-align: right;" class="form-control form-control-lg" value="<?php echo $totalSemIva ?>" readonly>

            <label>Total de Artigos Com Iva.: </label>
            <input type="text" name="comIVA" id="comIVA" style="width: 200px; text-align: right;" class="form-control form-control-lg" value="<?php echo $totalComIva ?>" readonly>


            <hr>

            <input type="hidden" name="dbTimeStamp" value="<?php echo  $dbTimeStamp ?>">
            <input type="submit" name="" id="btnSubmit" class="btn btn-primary" value="Processar" disabled>
            <button class="btn btn-danger" name="" id="recalcular">Recalcular Simulação</button>
        </form>
    </div>
    <script>
        var recalcular = document.getElementById('recalcular')

        /*  function getEntidade() {
             console.log('Clicou')
             var numProcesso = document.getElementById('numProcesso')
             
             var entidade = numProcesso.options[numProcesso.selectedIndex].getAttribute('data-entidade');
             var startHidden = document.getElementById('startHidden')
             var btnSubmit = document.getElementById('btnSubmit')
             console.log(entidade)
             if (entidade == 416 || entidade == 415) {
                 startHidden.style.display = 'block'
                 btnSubmit.disabled = false
             } else {
                 startHidden.style.display = 'none'
                 btnSubmit.disabled = true
             }
         } */
        recalcular.addEventListener('click', function() {
            event.preventDefault()
            console.log('Recalc')
            //var totalelegibilidade = document.getElementById('totalelegibilidade');
            var qnt = document.getElementsByName('qnt[]');
            var precoArtigo = document.getElementsByName('precoArtigo[]');
            var iva = document.getElementsByName('iva[]');
            var comIVA = document.getElementById('comIVA');
            var semIVA = document.getElementById('semIVA');
            var len = precoArtigo.length
            var totalComIva = 0
            var totalSemIva = 0

            for (let i = 0; i < len; i++) {
                if (iva[i].value == 14) {
                    totalComIva += qnt[i].value * precoArtigo[i].value
                } else {
                    totalSemIva += qnt[i].value * precoArtigo[i].value
                }

                console.log('Qnt: ' + qnt[i].value)
                console.log('Valor: ' + precoArtigo[i].value)
            }
            comIVA.value = totalComIva
            semIVA.value = totalSemIva
            totalelegibilidade.value = (totalComIva + totalSemIva)
            console.log('Com IVA: ' + totalComIva)
            console.log('Sem IVA: ' + totalSemIva)
        })

        function preenchCampos() {

            var numProcesso = document.getElementById('numProcesso')
            if (numProcesso.value == '') {
                alert('Você pecisa fazer uma consulta antes de adicionar uma artigo')
            } else {

                var form_data = new FormData()
                form_data.append('numProcesso', numProcesso.value)

                var ajaxRequest = new XMLHttpRequest()
                ajaxRequest.open('POST', 'findByNumeroProcesso.php')
                ajaxRequest.send(form_data)
                ajaxRequest.onreadystatechange = function() {
                    if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                        console.log('Consulta aqi ' + ajaxRequest.responseText)
                        var resposta = JSON.parse(ajaxRequest.responseText)
                        console.log('Resposta ' + resposta)
                        console.log('Resposta Size ' + resposta.length)
                        //console.log('Consulta ' + consulta.value)

                        if (resposta.length > 0) {
                            var idUtente = document.getElementById('idUtente')
                            var utente = document.getElementById('utente')
                            var entidade = document.getElementById('entidade')
                            var idEntidade = document.getElementById('idEntidade')
                            var startHidden = document.getElementById('startHidden')
                            var startHiddenOthers = document.getElementById('startHiddenOthers')

                            var btnSubmit = document.getElementById('btnSubmit')

                            idUtente.value = resposta[0].idUtente
                            utente.value = resposta[0].utente
                            idEntidade.value = resposta[0].idEntidade
                            

                            console.log('Id Entidsade ' + resposta[0].idEntidade)
                            if (resposta[0].idEntidade == 416 || resposta[0].idEntidade == 415) {
                                //startHiddenOthers.style.display = 'none'
                                startHidden.style.display = 'block'
                                btnSubmit.disabled = false
                            } else {
                                startHidden.style.display = 'none'
                                //startHiddenOthers.style.display = 'block'
                                btnSubmit.disabled = false
                            }
                        } else {
                            alert("Desculpa. Houve algum problema")
                        }
                    }
                }

            }
        }
    </script>
</body>

</html>