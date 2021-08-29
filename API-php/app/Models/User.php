<?php

namespace App\Models;

use \App\Db\Database;
use \PDO;

class User {
    private static $id;

    private static $table = 'users';

    /**
     * Выборка конкретного пользователя базы данных
     *
     * @param integer $id
     *
     * @return Database
     */
    public static function selectUser($id) {
        return (new Database(self::$table))->select($id)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Выборка всех пользователей, которые присутствуют в базе данных
     *
     * @return Database
     */
    public static function selectAllUsers() {
        return (new Database(self::$table))->selectAll()->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    
    /**
     * Вставка запрошенного пользователя в базу данных (email/password/name)
     *
     * @param POST $data
     * @return Database
     */
    public static function insert($data) {
        $obDatabase = new Database(self::$table);

        self::$id = $obDatabase->insert($data);

        return true;
    }
}