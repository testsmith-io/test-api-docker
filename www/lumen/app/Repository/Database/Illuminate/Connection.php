<?php declare(strict_types=1);

namespace TestApi\Repository\Database\Illuminate;

use Illuminate\Database\DatabaseManager;
use TestApi\Repository\Database\ConnectionInterface;
use TestApi\Repository\Database\Illuminate\Query\Builder;
use TestApi\Repository\Database\Query\BuilderInterface;

class Connection implements ConnectionInterface
{
    /**
     * @var \Illuminate\Database\Connection
     */
    private $connection;

    /**
     * @param \Illuminate\Database\DatabaseManager $connection
     */
    public function __construct(DatabaseManager $connection)
    {
        $this->connection = $connection->connection();
    }

    /**
     * @return \TestApi\Repository\Database\Query\BuilderInterface
     */
    public function query(): BuilderInterface
    {
        return new Builder($this->connection);
    }

    /**
     * @param string $table
     * @param array  $data
     *
     * @return bool
     */
    public function insert(string $table, array $data): bool
    {
        return $this->connection->table($table)->insert($data);
    }

    /**
     * @param string $table
     * @param array  $values
     * @param array  $where
     *
     * @return int
     */
    public function update(string $table, array $values, array $where): int
    {
        return $this->connection->table($table)->where($where)->update($values);
    }

    /**
     * @param string $table
     * @param array  $where
     *
     * @return bool
     */
    public function delete(string $table, array $where): bool
    {
        return (bool)$this->connection->table($table)->where($where)->delete();
    }

    /**
     * @return int
     */
    public function lastInsertedId(): int
    {
        return (int)$this->connection->getPdo()->lastInsertId();
    }

    /**
     * @param string $table
     *
     * @return int
     */
    public function count(string $table): int
    {
        return $this->connection->table($table)->count();
    }

    /**
     * @param \Closure $callback
     *
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function transaction(\Closure $callback)
    {
        return $this->connection->transaction($callback);
    }
}
