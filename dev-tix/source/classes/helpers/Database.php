<?php

class Database
{
    private PDO $pdo;
    private PDOStatement $pdoStatement;
    private static Database $instance;
    private array $params;

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

    public function executePreparedStatement(string $query, array $params = [])
    {
        $this->pdoStatement = empty($params) ? $this->pdo->query($query) : $this->pdo->prepare($query);

        if ($this->isQueryOfType('SELECT')) {
            if (!empty($params)) {
                foreach ($params as $name => $value) {
                    $dataType = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                    $this->pdoStatement->bindParam($name, $value, $dataType);
                }
            }
        } else {
            $this->params = $params;
        }

        return $this;
    }

    public function getQueryResult(bool $isAssoc = true)
    {
        if ($this->isQueryOfType('SELECT')) {
            if (!$this->pdoStatement->execute()) {  // Guard clause.
                return ['error' => 'Error processing prepared statement.'];
            }

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

        // Guard clause.
        if (!$this->pdoStatement->execute($this->params)) {
            return ['error' => 'Error processing prepared statement.'];
        }

        return ['success' => 'Prepared statement executed successfully.'];
    }

    private function isQueryOfType(string $type)
    {
        return str_contains($this->pdoStatement->queryString, $type);
    }
}
