<?php
class connection{
    public static function conectaSqlServer(){
        $server = '192.168.100.36';
        $databaseName = 'cligestdoc';
        $conn = new PDO("sqlsrv:Database = $databaseName;server = $server", "sa", "TESTDEV2021##!!", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $conn;
    }

    public static function conectaSqlServerCligestsi(){
        $server = '192.168.100.36';
        $databaseName = 'cligestsi';
        $conn = new PDO("sqlsrv:Database = $databaseName;server = $server", "sa", "TESTDEV2021##!!", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $conn;
    }
}
?>