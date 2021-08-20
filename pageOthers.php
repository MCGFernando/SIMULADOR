<?php
require_once "conexao.php";
require_once "dao.php";
$processo = $_POST['numProcesso'];
$fes = dao::pesquisaFichaEpisodioUtente($processo);
    $semIVA = $_POST['semIVA'];
    $comIVA = $_POST['comIVA'];

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
        <div id="startShowing">
            <h4>Crie na plataforma da seguradora Elegibilidades distanta (com IVA e sem IVA) com as seguintes artigos:</h4><br><br>
            <label for="">Utente.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $fes[0]['Default Utente'] ?>" readonly>
            <label for="">Ficha de Episódio.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $processo ?>" readonly>
            <label for="">Data.: </label><input type="text" name="" id="" class="form-control" value="<?php echo date_format($date, "Y-m-d H:i:s") ?>" readonly>
            <input type="hidden" name="consulta" id="consulta" value="<?php echo $dbTimeStamp ?>" readonly>
            <div class="input-group mb-2" style="width: 200px;">
                <label for="">Medicamentos Sem Iva.: </label>
                <input type="text" name="" id="semIVA" style="text-align: right;" class="form-control form-control-lg" value="<?php echo number_format($semIVA, 2, '.', '') ?>" readonly>
                <div class="input-group-append">
                    <button class="btn btn-success" onclick="javascript:copiaSemIVA()">Copiar</button>
                </div>
            </div>

            <div class="input-group mb-2" style="width: 200px;">
                <label for="">Medicamentos Com Iva.: </label>
                <input type="text" name="" id="comIVA" style="text-align: right;" class="form-control  form-control-lg" value="<?php echo  number_format($comIVA, 2, '.', '') ?>" readonly>
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
                        <th>IVA</th>
                        <th>Valor Unitario</th>
                        <th>Valor Unitario</th>
                        <th>Copago</th>
                        <th>Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Medicamentos com IVA</td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                    </tr>
                    <tr>
                        <td>Medicamentos sem IVA</td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                        <td><input type="text" name="" id="" class="form-control" value="" ></td>
                    </tr>
                </tbody>
            </table>

            <button class="btn btn-success" onclick="javascript:mostraResumoFinal()">Finalizar</button>
        </div>
    </div>

    <script>

    </script>
</body>

</html>