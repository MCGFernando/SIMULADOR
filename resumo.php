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
        <form action="insercaoController.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ARTIGO</th>
                        <th>QNT</th>
                        <th>CODE IVA</th>
                        <th>PREÇO ARTIGO</th>
                        <th>VALOR ARTIGO</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    for ($i = 0; $i < $len; $i++) {
                        if ($iva[$i]==14){
                            $totalComIva += $precoArtigo[$i]*$qnt[$i];
                        }else{
                            $totalSemIva += $precoArtigo[$i]*$qnt[$i];
                        }
                    ?>
                        <tr>
                            <td><input type="text" name="idArtigo[]" id="idArtigo" class="form-control" value="<?php echo $id[$i] ?>" readonly></td>
                            <td><input type="text" name="artigo[]" id="artigo" class="form-control" value="<?php echo $artigo[$i] ?>" readonly></td>
                            <td><input type="number" name="qnt[]" id="qnt" class="form-control" value="<?php echo $qnt[$i] ?>" ></td>
                            <input type="hidden" name="iva[]" id="iva" value="<?php echo $iva[$i] ?>">
                            <td><input type="text" name="" id="" class="form-control" value="<?php echo ($iva[$i]==14?"Artigo com IVA":"Artigo sem IVA") ?>" readonly></td>
                            <td><input type="text" name="precoArtigo[]" id="precoArtigo" class="form-control" value="<?php echo $precoArtigo[$i] ?>" readonly></td>
                            <td><input type="text" name="valorArtigo[]" id="valorArtigo" class="form-control" value="<?php echo $precoArtigo[$i] * $qnt[$i] ?>" readonly></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="form-group">
                <label for="numProcesso">1 - Passo) Selecione a Ficha de Episódio:</label>
                <select class="form-control" name="numProcesso" id="numProcesso" onchange="getEntidade()" require>
                    <option value="0" disabled selected>Selcione a Ficha de Episódio</option>
                    <?php foreach ($fes as $row) { ?>
                        <option value="<?php echo $row['Nº de Processo'] ?>" data-entidade="<?php echo $row['ID entidade'] ?>"><?php echo $row['Nº de Processo'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- <div class="form-group">
                <input type="text" name="idArtigo[]" id="idArtigo" class="form-control" value="<?php echo $id[$i] ?>" readonly>
            </div> -->

            <div style="display: none;" id="startHidden">
                <div class="form-group">
                    <label for="tipoArtigo">Tipo de Artigo</label>
                    <select class="form-control" name="tipoArtigo" id="tipoArtigo" require>
                        <option value="0" disabled selected>Selcione o Tipo de Artigo</option>
                        <option value="CONSUMIVEIS" >CONSUMIVEIS</option>
                        <option value="FARMACOS" >FARMACOS</option>
                        <option value="FARMACIA EXTERNA" >FARMACIA EXTERNA</option>
                        <option value="VACINAS" >VACINAS</option>
                    </select>
                </div>
            </div>
            <hr>
            

            Total de Artigos Sem Iva.: <input type="text" name="semIVA" id="semIVA" class="form-control" value="<?php echo $totalSemIva ?>" readonly>
            Total de Artigos Com Iva.: <input type="text" name="comIVA" id="comIVA" class="form-control" value="<?php echo $totalComIva ?>" readonly>
            <!--<br>
            Total da Elegibilidade.: <input type="text" name="" id="totalelegibilidade" class="form-control" value="<?php //echo ($totalComIva + $totalSemIva) ?>" readonly>-->
            <hr>
            <input type="hidden" name="dbTimeStamp" value="<?php echo  $dbTimeStamp?>">
            <input type="submit" name="" id="btnSubmit" class="btn btn-primary" value="Simular" disabled>
            <button class="btn btn-danger" name="" id="recalcular">Recalcular Simulação</button>
        </form>
    </div>
    <script>
        var recalcular = document.getElementById('recalcular')
        function getEntidade() {
            console.log('Clicou')
            var numProcesso = document.getElementById('numProcesso')
            var entidade = numProcesso.options[numProcesso.selectedIndex].getAttribute('data-entidade');
            var startHidden = document.getElementById('startHidden')
            var btnSubmit = document.getElementById('btnSubmit')
            console.log(entidade)
            if (entidade == 416 || entidade == 415) {
                startHidden.style.display =  'block'
                btnSubmit.disabled=  false
            }else{
                startHidden.style.display =  'none'
                btnSubmit.disabled =  true
            }
        }
        recalcular.addEventListener('click', function(){
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

            for(let i=0; i<len; i++){
                if(iva[i].value==14){
                    totalComIva += qnt[i].value * precoArtigo[i].value
                }else{
                    totalSemIva += qnt[i].value * precoArtigo[i].value
                }

                console.log('Qnt: ' + qnt[i].value)
                console.log('Valor: ' + precoArtigo[i].value)
            }
            comIVA.value = totalComIva
            semIVA.value = totalSemIva
            totalelegibilidade.value = (totalComIva+totalSemIva)
            console.log('Com IVA: ' + totalComIva)
            console.log('Sem IVA: ' + totalSemIva)
        })
    </script>
</body>

</html>