<?php
class connection{
    public static function conectaSqlServer(){        
        $serverName = "192.168.100.36";
    		$databaseName = "cligestdoc";
    		$uid = "SA";
    		$pwd = "TESTDEV2021##!!";

    		$conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $uid, $pwd);
        return $conn;
    }

    public static function conectaSqlServerCligestsi(){               
        $serverName = "192.168.100.36";
    		$databaseName = "cligestsi";
    		$uid = "SA";
    		$pwd = "TESTDEV2021##!!";

    		$conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $uid, $pwd);
        return $conn;
    }

    public static function conectaSqlServerCligestMain(){               
      $serverName = "192.168.100.36";
      $databaseName = "cligestmain";
      $uid = "SA";
      $pwd = "TESTDEV2021##!!";

      $conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $uid, $pwd);
      return $conn;
  }

    
}
?>