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
$iva = $_POST['valorArtigo'];
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
        <form action="">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ARTIGO</th>
                        <th>VALOR S/ IVA</th>
                        <th>VALOR C/ IVA</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    for ($i = 0; $i < $len; $i++) {
                        $totalSemIva += $iva[$i];
                        $totalComIva += $iva[$i];
                    ?>
                        <tr>
                            <td><input type="text" name="idArtigo[]" id="idArtigo" class="form-control" value="<?php echo $id[$i] ?>" readonly></td>
                            <td><input type="text" name="artigo[]" id="artigo" class="form-control" value="<?php echo $artigo[$i] ?>" readonly></td>
                            <td><input type="text" name="valorArtigo[]" id="valorArtigo" class="form-control" value="<?php echo $iva[$i] ?>" readonly></td>
                            <td><input type="text" name="REPLACE_NAME[]" id="REPLACE_ID" class="form-control" value="REPLACE_VALUE" readonly></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="form-group">
                <label for="numProcesso">Ficha de Episódio:</label>
                <select class="form-control" name="numProcesso" id="numProcesso" onchange="getEntidade()" require>
                    <option value="0">Selcione a Ficha de Episódio</option>
                    <?php foreach ($fes as $row) { ?>
                        <option value="<?php echo $row['Nº de Processo'] ?>" data-entidade="<?php echo $row['ID entidade'] ?>"><?php echo $row['Nº de Processo'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div style="display: none;" id="startHidden">
                <div class="form-group">
                    <label for="tipoArtigo">Tipo de Artigo</label>
                    <select class="form-control" name="tipoArtigo" id="tipoArtigo" require>
                        <option value="0">Selcione o Tipo de Artigo</option>
                        <option value="" >CONSUMIVEIS</option>
                        <option value="" >FARMACOS</option>
                        <option value="" >FARMACIA EXTERNA</option>
                        <option value="" >VACINAS</option>
                    </select>
                </div>
            </div>
            <hr>
            Total Com Iva.: <input type="text" name="" id="" class="form-control" value="<?php echo $totalSemIva ?>" readonly>
            Total Sem Iva.: <input type="text" name="" id="" class="form-control" value="<?php echo $totalComIva ?>" readonly>
            <hr>
            <input type="hidden" name="" value="<?php echo  $dbTimeStamp?>">
            <input type="submit" name="" id="btnSubmit" class="btn btn-primary" value="Finalizar Simulação" disabled>
            <button class="btn btn-danger">Cancelar Simulação</button>
        </form>
    </div>
    <script>
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
    </script>
</body>

</html>