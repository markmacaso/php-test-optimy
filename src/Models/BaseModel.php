<?php declare(strict_types = 1);

namespace OptimyTest\Models;

use OptimyTest\Database\Database;
use OptimyTest\Database\Query;

/**
 * Base model class
 */
class BaseModel
{
    /**
     * @var array
     */
    protected array $values;

    /**
     * @var array
     */
    protected array $newValues;

    /**
     * Class constructor
     *
     * @param array $values
     */
    public function __construct($values = [])
    {
        $this->values = $values;
    }

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * Create an entry into the database
     *
     * @param  array $data
     * @return BaseModel
     */
    static function create($data) : BaseModel
    {
        $class = get_called_class();
        $object = new $class();
        $database = Database::getInstance();
        $id = $database->insert($object->getTableName(), $data);

        return $class::find((int) $id);
    }

    /**
     * Get the list
     *
     * @return Query
     */
    static function list() : Query
    {
        $class = get_called_class();
        $object = new $class();
        $query = new Query($object);
        $query->select();

        return $query;
      
    }

    /**
     * Find by id
     *
     * @param  int $id
     * @return BaseModel:bool
     */
    static function find(int $id) : BaseModel|bool
    {
        $class = get_called_class();
        $object = new $class();
        $query = new Query($object);
        $object = $query->select()->where('id', '=', $id)->getOne();

        return $object;
      
    }

    /**
     * Delete object
     */
    public function delete()
    {
        $database = Database::getInstance();
        $database->delete(
            $this->getTableName(),
            [
                [
                    'id',
                    '=',
                    $this->id
                ]
            ]
        );
    }

    /**
     * Get the table columns
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Magic method to check if a value is set
     *
     * @param  string $key
     * @return mixed
     */
    public function __isset(string $key) : bool
    {
        return isset($this->newValues[$key]) || isset($this->values[$key]);
    }

    /**
     * Magic method to get a value
     *
     * @param  string $key
     * @return mixed
     */
    public function __get(string $key) : mixed
    {
        return isset($this->newValues[$key]) ?
            $this->newValues[$key] :
            (
                isset($this->values[$key]) ?
                $this->values[$key] :
                null
            );
    }

    /**
     * Magic method to set a value
     *
     * @param  string $key
     * @param  mixed $value
     */
    public function __set(string $key, mixed $value) : void
    {
        $this->newValues[$key] = $value;
    }

    /**
     * Generate table from the classname. This function can be expanded in the future.
     * 1. Allow setting a different table name
     * 2. Consider multiple work table name
     *
     * @return string
     */
    public function getTableName()
    {
        $className = get_class($this);

        if ($pos = strrpos($className, '\\')) {
            $className = substr($className, $pos + 1);
        }

        $tableName = strtolower($className);

        return $tableName;
    }
}