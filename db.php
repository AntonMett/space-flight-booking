<?php

class DB
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "flights";
    public $conn = "";

    function __construct()
    {
        /*
                    CONNECT TO DB USING PDO
        */
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbName}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "\n";
        }

    }

    public function createTable($tableName, $columnProps)
    {
        try {
            $sql = $this->conn->prepare("CREATE TABLE IF NOT EXISTS {$tableName} ({$columnProps})");
            $sql->execute();
        } catch (PDOException $exception) {
            echo "Table creation failed: " . $exception->getMessage() . "\n";
        }
    }

    public function insert($table, $column, array $values)
    {
        try {
            $placeHolder = implode(",", array_fill(0, count($values), "?"));
            $sql = $this->conn->prepare("INSERT IGNORE INTO {$table} ({$column}) VALUES({$placeHolder})");
            $sql->execute($values);
        } catch (PDOException $exception) {
            echo "Value insertion into table failed: " . $exception->getMessage() . "\n";
        }
    }

}
