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


    public static function pesquisaMaxIDFE(){
        $c = connection::conectaSqlServerCligestsi();
        $stmt = $c->prepare("SELECT Max([Registo FE].[ID Registo]) AS [idRegisto] FROM [Registo FE]");
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function pesquisaProducto($id){
        $c = connection::conectaSqlServer();
        $stmt = $c->prepare( "SELECT * FROM [Produto]  INNER JOIN IVA ON [ID Produto]=IVA.[ID Acto] WHERE [ID Produto] = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function pesquisaLogin($utilizador, $senha){
        $c = connection::conectaSqlServerCligestMain();
        $stmt = $c->prepare( "SELECT * FROM [Operador] WHERE [login] = '". $utilizador ."' AND password='". $senha."'");
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function pesquisaResumoFEOthers($idFE){
        $c = connection::conectaSqlServerCligestsi();
        $stmt = $c->prepare( "SELECT 
        f.[Default EXT], f.[Default Utente], f.[ID entidade], f.[Nº de Processo], f.[ID Ficha de Episódio],
        r.[ID Registo], r.[ID Acto], r.Acto, r.Classe, r.DataRegisto, r.Ordem , r.Coef, r.[Valor AKZ], 
        r.Elegibilidade, r.DataElegibilidade, r.Operador, r.Copagamento, r.IVA, r.[Preco AKZ], r.[PU AKZ], r.Qtd 
        FROM [FE] f INNER JOIN [Registo FE] r ON f.[ID Ficha de Episódio]=r.[ID FE] WHERE f.[ID Ficha de Episódio] = ?");
        $stmt->execute([$idFE]);
        $data = $stmt->fetchAll();
        return $data;
    }
}
?>