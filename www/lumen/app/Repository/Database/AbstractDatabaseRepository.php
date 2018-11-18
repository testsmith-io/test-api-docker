<?php declare(strict_types=1);

namespace TestApi\Repository\Database;

use TestApi\Entity\EntityInterface;
use TestApi\Entity\FactoryInterface;
use TestApi\Exceptions\Database\NotFoundException;
use TestApi\Exceptions\Repository\RepositoryException;
use TestApi\Repository\Database\Table\NameResolver;
use TestApi\Repository\RepositoryInterface;

abstract class AbstractDatabaseRepository implements RepositoryInterface
{
    /**
     * @var mixed
     */
    public $table;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var \TestApi\Entity\FactoryInterface
     */
    private $entityFactory;

    /**
     * @var \TestApi\Repository\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * @var \TestApi\Repository\Database\Table\NameResolver
     */
    private $nameResolver;

    /**
     * @param \TestApi\Repository\Database\ConnectionInterface $connection
     * @param \TestApi\Entity\FactoryInterface                 $entityFactory
     * @param \TestApi\Repository\Database\Table\NameResolver  $nameResolver
     */
    public function __construct(
        ConnectionInterface $connection,
        FactoryInterface $entityFactory,
        NameResolver $nameResolver
    ) {
        $this->connection    = $connection;
        $this->entityFactory = $entityFactory;
        $this->nameResolver  = $nameResolver;
    }

    /**
     * @return mixed|string
     */
    public function getTable()
    {
        return $this->table ?: $this->nameResolver->resolve($this);
    }

    /**
     * @param int $entityId
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Database\NotFoundException
     */
    public function get(int $entityId): EntityInterface
    {
        $table   = $this->getTable();
        $where   = [$this->primaryKey => $entityId];
        $results = $this->connection->query()->select()->from($table)->where($where)->get();
        $result  = array_pop($results);

        if (empty($result)) {
            throw new NotFoundException('Row (ID:%s) not found in `%s` table', [$entityId, $table]);
        }

        if ($result instanceof EntityInterface) {
            return $result;
        }

        return $this->entityFactory->create($table, $result);
    }

    /**
     * @param int|null $page
     * @param int|null $pageSize
     *
     * @return array
     */
    public function all(int $page = null, int $pageSize = null): array
    {
        $query   = $this->connection->query()->select()->from($this->getTable());
        $results = $pageSize ? $query->paginate($page, $pageSize) : $query->get();

        return $this->entityFactory->hydrate($this->getTable(), $results);
    }

    /**
     * @param int   $entityId
     * @param array $value
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Database\NotFoundException
     */
    public function update(int $entityId, array $value): EntityInterface
    {
        $where = [$this->primaryKey => $entityId];
        $this->connection->update($this->getTable(), $value, $where);

        return $this->get($entityId);
    }

    /**
     * @param array $value
     *
     * @return bool
     * @throws \TestApi\Exceptions\Repository\RepositoryException
     */
    public function add(array $value): bool
    {
        $insert = $this->connection->insert($this->getTable(), $value);
        if (!$insert) {
            throw new RepositoryException('Error occurred while adding a data');
        }

        return $insert;
    }

    /**
     * @param $entityId
     *
     * @return bool
     */
    public function remove(int $entityId): bool
    {
        $where = [$this->primaryKey => $entityId];

        return $this->connection->delete($this->getTable(), $where);
    }

    /**
     * @return int
     * @throws \TestApi\Exceptions\Repository\RepositoryException
     */
    public function lastInsertedId(): int
    {
        $lastInsertedId = $this->connection->lastInsertedId();
        if (!$lastInsertedId) {
            throw new RepositoryException('Could not fetch a last inserted ID');
        }

        return $lastInsertedId;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->connection->count($this->getTable());
    }
}
