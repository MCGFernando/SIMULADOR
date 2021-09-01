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
<?php
    session_start();
    $feRegisto = $_SESSION['feRegisto'] ;
	include('navbar.html'); 
?>
    <div class="container">
        <h2>Resumo da Simulação</h2>
        <div class="card-body">
            <label for="">Utente.: </label><input type="text" name="" id="" class="form-control" value="<?php echo $feRegisto[0]['Default Utente'] ?>" readonly>
            <label for="">Elegibilidades</label>
            <input type="text" name="" id="elegibilidade" class="form-control" value="<?php echo $feRegisto[0]['Elegibilidade'] ?>" readonly>
			<input type="text" name="" id="elegibilidade" class="form-control" value="<?php echo $feRegisto[1]['Elegibilidade'] ?>" readonly>
            <label for="">Ficha de Episódio</label>
            <input type="text" name="" id="fe" class="form-control" value="<?php echo $feRegisto[0]['Nº de Processo'] ?>" readonly>

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
                    <?php foreach($feRegisto as $row) {?>
                    <tr>
                        <td><?php echo $row['Acto'] ?></td>
                        <td><?php echo $row['Copagamento'] ?></td>
                        <td><?php echo $row['IVA'] ?></td>
                        <td><?php echo $row['Qtd'] ?></td>
                        <td><?php echo $row['Valor AKZ'] ?></td>
                        <td><?php echo $row['Valor AKZ'] ?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>

            <hr>
            <a href="home.html" class="btn btn-primary">Fazer Nova Simulação</a>
        </div>
    </div>
</body>

</html>