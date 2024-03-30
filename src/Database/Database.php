<?php declare(strict_types = 1);

namespace OptimyTest\Database;

use OptimyTest\Helpers\Config;
use PDO;

/**
 * Database class
 */
class Database
{
    /**
     * @var PDO
     */
	private $connection;

    /**
     * @var Database
     */
	private static $instance = null;

    /**
     * Class constructor
     *
     * @param array $config
     */
	private function __construct($config)
	{
        $config = (object) $config;
		$dsn = "{$config->driver}:host={$config->host};dbname={$config->database};port={$config->port}";
		$user = $config->username;
		$password = $config->password;

		$this->connection = new PDO($dsn, $user, $password);
	}

    /**
     * Get the singleton instance of the database
     */
	public static function getInstance()
	{
		if (null === self::$instance) {
            $config = Config::get('database');
			$c = __CLASS__;
			self::$instance = new $c($config);
		}
		return self::$instance;
	}

    /**
     * Select rows using the passed sql
     *
     * @param  string $sql
     * @return array
     */
	public function select($sql)
	{
        $sth = $this->connection->query($sql);
		return $sth->fetchAll();
	}

    /**
     * Select one row from the sql
     *
     * @param string $sql
     */
    public function selectOne($sql)
	{
        $sth = $this->connection->query($sql);
		return $sth->fetch();
	}

    /**
     * Insert new row into the table
     *
     * @param string $tableName
     * @param array $data
    */
    public function insert($tableName, $data)
    {
        $fields = '';
        $columns = '';

        foreach ($data as $key => $value) {
            if (!empty($fields)) {
                $fields .= ',';
            }
            if (!empty($columns)) {
                $columns .= ',';
            }
            $fields .= "`{$key}`";
            $columns .= "'{$value}'";
        }

        $sql = "INSERT INTO `{$tableName}` ($fields) VALUES($columns)";
		$this->exec($sql);
		return $this->lastInsertId();
    }

    /**
     * Delete from the table
     *
     * @param string $tableName
     * @param array $where
    */
    public function delete($tableName, $where)
    {
        if (empty($where)) {
            throw new \Exception('Error when deleting');
        }

        $conditions = '';

        foreach ($where as $condition) {
            if (!empty($conditions)) {
                $conditions .= ' AND ';
            }
            $conditions .= "`{$condition[0]}` {$condition[1]} '{$condition[2]}'";
        }

        $sql = "DELETE FROM `{$tableName}` WHERE {$conditions}";
		$this->exec($sql);
    }

    /**
     * Execute an sql
     *
     * @param string $sql
     */
	public function exec($sql)
	{
		return $this->connection->exec($sql);
	}

    /**
     * Get the id of the last inserted row
     */
	public function lastInsertId()
	{
		return $this->connection->lastInsertId();
	}
}