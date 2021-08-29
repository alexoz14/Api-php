<?php

namespace App\Db;

use \PDO;
use \PDOExpection;

class Database {

    /**
     * Тип, используемого в соединения
     *
     * @var [type]
     */
    private $DRIVE;

    /**
     * Хост подключения к базе данных
     *
     * @var string
     */
    private $HOST;

    /**
     * Имя базы данных
     *
     * @var string
     */
    private $NAME;

    /**
     * User name
     *
     * @var string
     */
    private $USERNAME;

    /**
     * Пароль доступа к базе данных
     *
     * @var string
     */
    private $PASSWORD;

    /**
     * Имя таблицы
     *
     * @var string
     */
    private $table;

    /**
     * Подключение к базе данных
     *
     * @var PDO
     */
    private $connection;

    /**
     * Определяем таблицу и устанавливаем соединение
     *
     * @param  string  $table
     *
     */

    public function __construct($table = null) {
        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection() {
        try {
            $this->setEnvironmentVariables();

            $this->connection = new PDO($this->DRIVE . ':host=' . $this->HOST . ';dbname=' . $this->NAME, $this->USERNAME, $this->PASSWORD);

            // Mostrar erros PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(Expection $error) {
            echo 'Ошибка: ' . $error->getMessage();
        } catch(PDOExpection $error) {
            echo 'Ошибка базы данных: ' . $error->getMessage(); exit;
        }
    }

    private function setEnvironmentVariables() {
        $this->DRIVE    = getenv('DB_DRIVE');
        $this->HOST     = getenv('DB_HOST');
        $this->NAME     = getenv('DB_NAME');
        $this->USERNAME = getenv('DB_USER');
        $this->PASSWORD = getenv('DB_PASSWORD');
    }

    private function execute($query, $params = []) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);

            return $statement;

        } catch(Exception $error) {
            echo 'Ошибка: ' . $error->getMessage();
        } catch(PDOException $error) {
            echo 'Ошибка базы данных: ' . $error->getMessage();
        }
    }

    public function select($where = null) {
        // Dados da query
        $where = strlen($where) ? 'WHERE id = '. $where : '';

        $query = 'SELECT * FROM '. $this->table . ' ' . $where;

        return $this->execute($query);
    }

    public function selectAll() {
        $query = 'SELECT * FROM '. $this->table;

        return $this->execute($query);
    }

    public function insert($data) {
        $fields = array_keys($data);
        $binds = array_pad([], count($fields), '?');

        $query = "INSERT INTO " . $this->table . " (". implode(',', $fields). ") VALUES (". implode(',', $binds) . ")";

        $this->execute($query, array_values($data));

        return $this->connection->lastInsertId();
    }

}