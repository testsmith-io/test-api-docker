<?php declare(strict_types=1);

namespace TestApi\Repository\Database\Query;

interface BuilderInterface
{
    /**
     * @param array|null $columns
     *
     * @return \TestApi\Repository\Database\Query\BuilderInterface
     */
    public function select(array $columns = null): BuilderInterface;

    /**
     * @param string $table
     *
     * @return \TestApi\Repository\Database\Query\BuilderInterface
     */
    public function from(string $table): BuilderInterface;

    /**
     * @param array $where
     *
     * @return \TestApi\Repository\Database\Query\BuilderInterface
     */
    public function where(array $where): BuilderInterface;

    /**
     * @param array $order
     *
     * @return \TestApi\Repository\Database\Query\BuilderInterface
     */
    public function order(array $order): BuilderInterface;

    /**
     * @param int $limit
     *
     * @return \TestApi\Repository\Database\Query\BuilderInterface
     */
    public function limit(int $limit): BuilderInterface;

    /**
     * @return array
     */
    public function get(): array;

    /**
     * @param int|null $page
     * @param int      $pageSize
     *
     * @return array
     */
    public function paginate(?int $page, int $pageSize): array;
}
