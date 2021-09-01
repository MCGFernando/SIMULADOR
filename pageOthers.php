<?php
require_once "conexao.php";
require_once "dao.php";
$processo = $_POST['numProcesso'];

$fes = dao::pesquisaFichaEpisodioUtente($processo);
$semIVA = $_POST['semIVA'];
$comIVA = $_POST['comIVA'];
/* for ($i = 0; $i < $len; $i++){
    echo "Artigo" . $id[$i];
} */
session_start();
$_SESSION['idArtigo'] = $id;
$_SESSION['qnt'] = $qnt;
$_SESSION['valorComArtigo'] = $valorArtigo;
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
        <div id="startShowing">
            <form action="insercaoOthersController.php" method="post">
                <h4>Crie na plataforma da seguradora Elegibilidades distanta (com IVA e sem IVA) com as seguintes artigos:</h4><br><br>

                <label for="">Utente.: </label><input type="text" name="utente" id="" class="form-control" value="<?php echo $fes[0]['Default Utente'] ?>" readonly>
                <label for="">Ficha de Episódio.: </label><input type="text" name="processo" id="" class="form-control" value="<?php echo $processo ?>" readonly>
                <label for="">Data.: </label><input type="text" name="" id="" class="form-control" value="" readonly>
                
                <input type="hidden" name="dataEntrada" id="dataEntrada" value="<?php echo $fes[0]['Data de Entrada'] ?>" readonly>
                <input type="hidden" name="idFe" id="idFe" value="<?php echo $fes[0]['ID Ficha de Episódio'] ?>" readonly>
                <input type="hidden" name="idUtente" id="idUtente" value="<?php echo $fes[0]['Default EXT'] ?>" readonly>
                <input type="hidden" name="consulta" id="consulta" value="<?php echo $dbTimeStamp ?>" readonly>
                
                <div class="input-group mb-2" style="width: 200px;">
                    <label for="">Medicamentos Sem Iva.: </label>
                    <input type="text" name="medicamentosSemIVA" id="medicamentosSemIVA" style="text-align: right;" class="form-control form-control-lg" value="<?php echo number_format($semIVA, 2, '.', '') ?>" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-success"  onclick="javascript:copiaSemIVA()">Copiar</button>
                    </div>
                </div>

                <div class="input-group mb-2" style="width: 200px;">
                    <label for="">Medicamentos Com Iva.: </label>
                    <input type="text" name="medicamentosComIVA" id="medicamentosComIVA" style="text-align: right;" class="form-control  form-control-lg" value="<?php echo  number_format($comIVA, 2, '.', '') ?>" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-success" onclick="javascript:copiaComIVA()">Copiar</button>

                    </div>
                </div>
                <h4>Após criar a Elegibilidade, regresse a esta página e preencha os valores de cada elegibilidade nos respectivos campos abaixo:</h4><br><br>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Nº DA GUIA</th>
                            <th>Copago</th>
							<th>Valor Total</th>    
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Medicamentos sem IVA</td>
                            <td><input type="text" name="guia" id="" class="form-control" value=""></td>
                            <td><input type="text" name="copamento" id="copamento" class="form-control" value="" ></td>
                            <td><input type="text" name="valorTotalGuia" id="valorTotalGuia" class="form-control" value="" ></td>                            
                        </tr>
                        <tr>
                            <td>Medicamentos com IVA</td>
                            <td><input type="text" name="guiaIVA" id="" class="form-control" value=""></td>
                            <td><input type="text" name="copamentoIVA" id="copamentoIVA" class="form-control" value="" ></td>
                            <td><input type="text" name="valorTotalGuiaIVA" id="valorTotalGuiaIVA" class="form-control" value="" ></td>                            
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-success">Finalizar</button>
            </form>
        </div>
    </div>

    <script>
	var medicamentosSemIVA = document.getElementById('medicamentosSemIVA')
	var medicamentosComIVA = document.getElementById('medicamentosComIVA')
	
	if(medicamentosComIVA.value>0){
		console.log(medicamentosComIVA.value)
		document.getElementById('copamentoIVA').required  = true
		document.getElementById('valorTotalGuiaIVA').required  = true
	}
	
	if(medicamentosSemIVA.value>0){
		console.log(medicamentosSemIVA.value)
		document.getElementById('copamento').required  = true
		document.getElementById('valorTotalGuia').required  = true
	}
function copiaSemIVA(){
            event.preventDefault()
            var copiaTexto = document.getElementById("medicamentosSemIVA")
            copiaTexto.select()
            copiaTexto.setSelectionRange(0, 99999)
            document.execCommand("copy")
            //alert('copio')
        }
        function copiaComIVA(){
            event.preventDefault()
            var copiaTexto = document.getElementById("medicamentosComIVA")
            copiaTexto.select()
            copiaTexto.setSelectionRange(0, 99999)
            document.execCommand("copy")
            //alert('copio')
        }
    </script>
</body>

</html>