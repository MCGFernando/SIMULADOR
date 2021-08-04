<?php
class connection{
    public static function conectaSqlServer(){
        $server = '192.168.100.37';
        $databaseName = 'cligestdoc';
        $conn = new PDO("sqlsrv:Database = $databaseName;server = $server", "sa", "Cligest2021!!##", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $conn;
    }

    public static function conectaSqlServerCligestsi(){
        $server = '192.168.100.37';
        $databaseName = 'cligestsi';
        $conn = new PDO("sqlsrv:Database = $databaseName;server = $server", "sa", "Cligest2021!!##", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $conn;
    }
}
?>