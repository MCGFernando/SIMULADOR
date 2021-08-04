<?php
require_once "conexao.php";
require_once "dao.php";
//$c = connection::conectaSqlServer();


$fes = dao::pesquisaFichaEpisodio();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js" defer></script>
    <script src="jquery/jquery-1.4.2.min_.js" ></script>
    <script src="jquery/jquery.autocomplete.js" ></script>
    <link rel="stylesheet" href="css/style.css">
    <script>
        jQuery(function(){
            $("pesquisa").autocomplete("pesquisaAutpcomplete.php")
        });
    </script>
    <title>Document</title>
</head>

<body>
    <form action="controller.php" method="get" id="formulario">
        <label for="">Tipo de Artigo</label>
        <input type="text" name="tipoartigo" id="tipoartigo" value="<?php echo $_POST['tipoartigo'] ?>" readonly><br>
        
        <label for="">Ficha de Episódio</label>
        <select name="fe" id="fe">
            <option value="">Seleciona a Ficha de Episódio</option>
            <?php foreach ($fes as $row) { ?>
                <option value="<?php echo $row['Nº de Processo'] ?>"><?php echo $row['Nº de Processo'] ?></option>
            <?php } ?>
        </select><br>
        
        <label for="">Seleciona Artigo</label>
        <input type="text" name="pesquisa" id="pesquisa">


        <div id="adicinarcampo">

            <table style="display: block;" id="maintable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ARTIGO</th>
                        <th>PREÇO</th>
                        <th>PREÇO S/ IVA</th>
                        <th>IVA</th>
                        <th>PREÇO C/ IVA</th>
                        <th>ACÇÃo</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <hr>
        <label for="">Total com IVA</label>
        <input type="text" name="" id="" value="" readonly><br>
        <label for="">Total sem IVA</label>
        <input type="text" name="" id="" value="" readonly><br>
        <input type="submit" value="Finalizar">
    </form>
    <script>

    </script>
</body>

</html>