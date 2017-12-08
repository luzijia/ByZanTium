<?php
namespace Component\DB;
use PDO AS PDO;

class MySqlBase
{
    private $Host;
    private $DBName;
    private $DBUser;
    private $DBPassword;
    private $DBPort;
    private $pdo;
    private $sQuery;
    private $Connected = false;
    private $parameters;
    private $Persistent;
    private $Debug     = false;

    public function __construct($Host, $DBName, $DBUser, $DBPassword, $DBPort = 3306,$Persistent=false)
    {
        $this->Host       = $Host;
        $this->DBName     = $DBName;
        $this->DBUser     = $DBUser;
        $this->DBPassword = $DBPassword;
        $this->DBPort	  = $DBPort;
        $this->Persistent = $Persistent;
        $this->parameters = array();
    }

    private function initDsn()
    {
        return 'mysql:dbname='.$this->DBName.';host='.$this->Host.';port='.$this->DBPort.';charset=utf8';
    }

    public function setDebug($debug=true)
    {
        $this->Debug = $debug;
    }

    private function Connect()
    {
        try {
            $this->pdo = new PDO($this->initDsn(),$this->DBUser,$this->DBPassword,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_PERSISTENT => $this->Persistent,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                )
            );
            $this->Connected = true;
        }
        catch (PDOException $e) {
            echo $this->ExceptionLog("Connect Error:".$e->getMessage());
        }
    }

    public function CloseDb()
    {
        $this->pdo = null;
    }

    private function init($query, $parameters = "")
    {
        if (!$this->Connected)$this->Connect();

        try {
            $this->parameters = $parameters;
            $this->sQuery     = $this->pdo->prepare($this->BuildParams($query, $this->parameters));

            if (!empty($this->parameters)){
                if (array_key_exists(0, $parameters)) {
                    $parametersType = true;
                    array_unshift($this->parameters, "");
                    unset($this->parameters[0]);
                } else {
                    $parametersType = false;
                }
                foreach ($this->parameters as $column => $value) {
                    $this->sQuery->bindParam($parametersType ? intval($column) : ":".$column,$this->parameters[$column]);
                }
            }

            $this->sQuery->execute();

            if($this->Debug)$this->sQuery->debugDumpParams();
        }
        catch (PDOException $e) {
            $this->ExceptionLog($e->getMessage(), $this->BuildParams($query));
        }

        $this->parameters = array();
    }

    private function BuildParams($query, $params = null)
    {
        if (!empty($params)) {
            $rawStatement = explode(" ", $query);
            foreach ($rawStatement as $value) {
                if (strtolower($value) == 'in') {
                    return str_replace("(?)", "(" . implode(",", array_fill(0, count($params), "?")) . ")", $query);
                }
            }
        }
        return $query;
    }

    public function query($query, $params = null)
    {
        $query        = trim($query);
        $rawStatement = explode(" ", $query);
        $this->init($query, $params);
        $statement = strtolower($rawStatement[0]);
		if ($statement === 'select') {
            return $this->getRows($query,$params);
        }
        return $this->sQuery->rowCount();
    }

    public function getOne($query,$params = null)
    {
		$this->init($query,$params);
		return $this->sQuery->fetch(PDO::FETCH_ASSOC);
    }

    public function getRows($query,$params=null)
    {
		$this->init($query,$params);
		return $this->sQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction()
    {
        if (!$this->Connected)$this->Connect();
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        if (!$this->Connected)$this->Connect();
        $this->pdo->commit();
    }

    public function rollback()
    {
        if (!$this->Connected)$this->Connect();
        $this->pdo->rollback();
    }

    private function ExceptionLog($message, $sql = "")
    {
        $exception = $message;

        if (!empty($sql)) {
            $message .= "\r\nRaw SQL : " . $sql;
        }
        return $exception;
    }
}
