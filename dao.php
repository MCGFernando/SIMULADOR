<?php
require_once "conexao.php";

class dao{    
    public static function pesquisaProdutoRequestPorTimestamp($dbTimeStamp){
        $c = connection::conectaSqlServerCligestsi();
        $pesquisa = $dbTimeStamp;//$_POST['pesquisa'];
        $stmt = $c->prepare("SELECT * FROM ActsClinicRequest WHERE [date_request] = '".date('Y-m-d H:i:s',$pesquisa)."'");
        //$stmt->execute([$pesquisa]);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return count($result);
    }

    public static function pesquisaFichaEpisodio(){
        $c = connection::conectaSqlServerCligestsi();
        $stmt = $c->prepare("SELECT f.[Default EXT], f.[Default Utente], f.[ID entidade], f.[Nº de Processo], f.[ID Ficha de Episódio] 
         FROM FE f INNER JOIN Marcação m ON f.[ID Ficha de Episódio] = m.[ID FE] WHERE f.[Data de Entrada] = ? AND m.Estado = 'EM CURSO'");
        $stmt->execute([date("Y/m/d")]);
        $data = $stmt->fetchAll();
        return $data;
    }  

    public static function pesquisaFichaEpisodioUtente($processo){
        $c = connection::conectaSqlServerCligestsi();
        $stmt = $c->prepare("SELECT f.[Default EXT], f.[Default Utente], f.[ID entidade], f.[Nº de Processo], f.[ID Ficha de Episódio], f.[Data de Entrada]
         FROM FE f WHERE f.[Nº de Processo] = '".$processo."'");
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }
}
?>