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
        $c = connection::conectaSqlServer();
        $stmt = $c->prepare("SELECT * FROM FE WHERE DATA = ?");
        $stmt->execute([date("d/m/Y")]);
        $data = $stmt->fetchAll();
        return $data;
    }  
}
?>