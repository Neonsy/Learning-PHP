<?php

declare(strict_types=1);

namespace MVCSpace\Core\Service\Services;

use MVCSpace\Core\App;
use PDO;
use PDOException;
use PDOStatement;

/**
 * THis class serves as a customized PDO wrapper.
 */
class Database
{
    /**
     * @var PDO $pdo The PDO connection instance.
     */
    private PDO $pdo;
    /**
     * @var PDOStatement $statement Holds the current statement.
     */
    private PDOStatement $statement;

    public function __construct(string $dsn, string $username, string $password)
    {
        $this->pdo = new PDO($dsn, $username, $password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Makes and executes a query.
     * @param string $sql
     * @param array $params
     * @return $this For chaining
     * @see self::fetch()
     */
    public function query(string $sql, array $params = []): self
    {
        $this->statement = $this->pdo->prepare($sql);
        try {
            $this->statement->execute($params);
        } catch (PDOException $e) {
            App::dump($e->getMessage(), exit: true);
        }

        return $this;
    }

    /**
     * Fetches the last query.
     * @param bool $all
     * @return array|bool
     */
    public function fetch(bool $all = false): array|bool
    {
        if ($all) {
            return $this->statement->fetchAll();
        } else {
            return $this->statement->fetch();
        }
    }
}