<?php
class DBController {
    protected $db;
    function __construct() {
        $this->db = $this->connectDB();
    }
    function __destruct() {
		    $this->db = null;
    }
    private function connectDB() {
        $hostName = $_SERVER['SERVER_NAME'];

        if($hostName == 'admin.bodwell.edu') {
          $dsn = "odbc:Driver={SQL Server};Server=10.0.0.108;Database=Bodwell;Uid=sa;Pwd=Yv9FrUpx0a;";
        } elseif ($hostName == 'msgctr.bodwell.edu') {
          $dsn = "odbc:Driver={SQL Server};Server=10.100.4.6;Database=Bodwell;Uid=web;Pwd=AJgw!cG4nw;";
        } elseif ($hostName == 'dev.bodwell.edu') {
          $dsn = "odbc:Driver={SQL Server};Server=10.100.0.5;Database=Bodwell;Uid=devweb;Pwd=9zQjq4WRgkFF;";
        } else {
          $dsn = "odbc:Driver={SQL Server};Server=10.100.0.5;Database=Bodwell;Uid=devweb;Pwd=9zQjq4WRgkFF;";
        }

        $conn = new PDO($dsn);

        return $conn;
    }
}
?>
