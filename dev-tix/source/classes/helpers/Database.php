<?php

class Database
{
    // Attributes.
    private PDO $pdo;
    private PDOStatement $pdoStatement;
    private static Database $instance;
    private array $params;

    /**
     * Singleton constructor.
     * @param string $dbName - database name.
     * @param string $dbUser - db access username.
     * @param string $dbPass - db access password.
     */
    private function __construct(string $dbName, string $dbUser, string $dbPass)
    {
        $dsn = "mysql:dbname={$dbName};host=localhost";
        $this->pdo = new PDO($dsn, $dbUser, $dbPass);
    }

    /**
     * Get Singleton instance.
     * @return Database - Database instance.
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database(DB_NAME, DB_USER, DB_PASS);
        }

        return self::$instance;
    }

    public function getQueryOutput()
    {
        $query = $this->pdoStatement->queryString;
        foreach ($this->params as $key => $value) {
            if (str_contains($query, $key)) {
                $query = str_replace($key, $value, $query);
            }
        }

        return $query;
    }

    /**
     * Execute a query.
     * @param string $query - query to be executed.
     * @param array $params - query parameters.
     * @return - same instance ($this).
     */
    public function executeQuery(string $query, array $params = [])
    {
        $this->pdoStatement = empty($params) ? $this->pdo->query($query) : $this->pdo->prepare($query);

        if ($this->isQueryOfType('SELECT')) {
            if (!empty($params)) {
                foreach ($params as $name => $value) {
                    $dataType = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                    $this->pdoStatement->bindValue($name, $value, $dataType);
                }

                $this->params = $params;
            }
        } else {
            $this->params = $params;
        }

        return $this;
    }

    /**
     * Get prepared statement results.
     * @param bool $isAssoc - will data be associative.
     * @return array - result or success/error message.
     */
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

    /**
     * Check type of query.
     * @param string $type - possible query type.
     * @return bool - whether it matches or not.
     */
    private function isQueryOfType(string $type)
    {
        return str_contains($this->pdoStatement->queryString, $type);
    }
}
