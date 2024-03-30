<?php declare(strict_types = 1);

namespace OptimyTest\Database;

use OptimyTest\Models\BaseModel;

/**
 * Query class
 */
class Query
{
    /**
     * @var BaseModel
     */
    protected BaseModel $model;

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @var array
     */
    protected array $where = [];

    /**
     * @var int
     */
    protected int $limit = 0;

    /**
     * Class constructor
     *
     * @param BaseModel $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * Select from table
     *
     * @param  string $tableName
     * @param  array $columns
     * @return Query
     */
    public function select(array $columns = []) : Query
	{
        $this->columns = $columns;

        return $this;
	}

    /**
     * Select from table
     *
     * @param  string $columnName
     * @param  string $operator
     * @param  mixed $value
     * @return Query
     */
    public function where(string $columnName, string $operator, mixed $value) : Query
	{
        $this->where[] = [
            $columnName,
            $operator,
            $value
        ];

        return $this;
	}

    /**
     * Get the objects
     *
     * @return array
     */
    public function get() : array
    {
        $sql = $this->buildQuery();
        $database = Database::getInstance();
        $rows = $database->select($sql);
        $class = get_class($this->model);
        $objects = [];

        foreach ($rows as $row) {
            $object = new $class($row);
            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * Get one object
     *
     * @return BaseModel|bool
     */
    public function getOne() : BaseModel|bool
    {
        $this->limit = 1;
        $sql = $this->buildQuery();
        $database = Database::getInstance();
        $row = $database->selectOne($sql);
        
        if (!$row) {
            return false;
        }

        $class = get_class($this->model);
        $object = new $class($row);

        return $object;
    }

    /**
     * Build the sql query
     *
     * @return string
     */
	protected function buildQuery() : string
    {
        $columns = !empty($this->columns) ? $this->columns : $this->model->getColumns();
        $columnList = $columns ? ('`' . implode('`,`', $columns) . '`') : '*';

        $tableName = $this->model->getTableName();

        $sql = "SELECT {$columnList} FROM {$tableName}";
        $conditions = '';

        foreach ($this->where as $condition) {
            if (!empty($conditions)) {
                $conditions .= ' AND ';
            }
            $conditions .= "`{$condition[0]}` {$condition[1]} '{$condition[2]}'";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE {$conditions}";
        }

        if ($this->limit > 0) {
            $sql .= ' LIMIT ' . $this->limit;
        }

        return $sql;
    }
}