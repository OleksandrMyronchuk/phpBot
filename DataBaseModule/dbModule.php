<?php

class DBModule
{
    public $pdo;
    private $dsn;
    private $opt;
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    function __construct() {
        $dbConnect = file_get_contents(ABSPATH . 'dbConnect.json');
        $dbConnect = json_decode($dbConnect, true);
        $this->host = $dbConnect['host'];
        $this->username = $dbConnect['username'];
        $this->password = $dbConnect['password'];
        $this->dbname = $dbConnect['dbname'];
        $this->charset = $dbConnect['charset'];
    }

    function __destruct() {}

    function ConnectToDB()
    {
        $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' . $this->charset;
        $this->opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->opt);
    }

    function Query($cmd)
    {
        $sth = $this->pdo->prepare($cmd);
        $sth->execute();
        return $sth->fetchAll();
    }

    function Execute($cmd)
    {
        return $this->pdo->exec($cmd);
    }

    function Insert(
        $tableName,
        $fieldNames,
        $fieldValues
    )
    {
        if (count ($fieldNames) != count ($fieldValues))
        {
            throw new Exception('Error! Number of the $fieldNames and $fieldValues are not equal.');
        }
        if(count ($fieldNames) == 0)
        {
            throw new Exception('Error! Number of the $fieldNames and $fieldValues are equal to null.');
        }

        $allFieldNames = ' ( ' . join(', ', $fieldNames) . ' ) ';
        $allFieldValues = ' ( :' . join(', :', $fieldNames) . ' ) ';

        $CommandText =
            "INSERT INTO " .
            $tableName .
            $allFieldNames .
            " VALUES " .
            $allFieldValues;

        $pdoStatement = $this->pdo->prepare($CommandText);

        for ($i = 0; $i < count($fieldValues); $i++)
        {
            $pdoStatement->bindParam(':'.$fieldNames[$i], $fieldValues[$i], PDO::PARAM_STR);
        }

        $pdoStatement->execute();
    }
}
