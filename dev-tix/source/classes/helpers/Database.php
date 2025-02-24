<?php

class Database
{
    private PDO $pdo;
    private $pdoStatement;
    private static Database $instance;

    private function __construct(string $dbName, string $dbUser, string $dbPass)
    {
        $dsn = "mysql:dbname={$dbName};host=localhost";
        $this->pdo = new PDO($dsn, $dbUser, $dbPass);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database(DB_NAME, DB_USER, DB_PASS);
        }

        return self::$instance;
    }

    public function executePreparedStatement(string $query, array $params)
    {
        $this->pdoStatement = $this->pdo->prepare($query);

        foreach ($params as $name => $value) {
            $dataType = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->pdoStatement->bindParam($name, $value, $dataType);
        }

        return $this;
    }

    public function getQueryResult(bool $isAssoc = true)
    {
        // Guard clause.
        if (!$this->pdoStatement->execute()) {
            return ['error' => 'Error processing prepared statement.'];
        }

        if (preg_match('#^SELECT#', $this->pdoStatement->queryString)) {
            $multipleRows = $this->pdoStatement->fetchAll($isAssoc ? PDO::FETCH_ASSOC : PDO::FETCH_DEFAULT);

            if (count($multipleRows) === 1) {
                $singleRows = [];

                foreach ($multipleRows as $nestedArray) {
                    foreach ($nestedArray as $key => $value) {
                        $singleRows[$key] = $value;
                    }
                }

                return $singleRows;
            }

            return $multipleRows;
        }

        return ['success' => 'Prepared statement executed successfully.'];
    }
}
