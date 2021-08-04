<?php
require_once "conexao.php";

class dao{
    public static function pesquisaAutocomplete(){
        $c = connection::conectaSqlServer();
        $pesquisa = $_POST['pesquisa'];
        $stmt = $c->prepare("SELECT * FROM Acto WHERE [Acto] = '%".$pesquisa."%'");
        //$stmt->execute([$pesquisa]);
        $stmt->execute();
        $result = $stmt->fetch();
        //if($result->num_ro)
        foreach($result as $rows){
            echo $rows["Actos"] . "<br>";
        }
    }

    public static function pesquisaFichaEpisodio(){
        $c = connection::conectaSqlServerCligestsi();
        $stmt = $c->prepare("SELECT f.[Default EXT], f.[Default Utente], f.[ID entidade], f.[Nº de Processo], f.[ID Ficha de Episódio] 
         FROM FE f INNER JOIN Marcação m ON f.[ID Ficha de Episódio] = m.[ID FE] WHERE f.[Data de Entrada] = ? AND m.Estado = 'FECHADO'");
        $stmt->execute([date("d/m/Y")]);
        $data = $stmt->fetchAll();
        return $data;
    }  
}
?>