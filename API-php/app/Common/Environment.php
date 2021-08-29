<?php

namespace App\Common;

class Environment {

   /**
    * Метод, отвечающий за загрузку переменных окружения проекта
    * @param string $dir абсолютный путь к папке, в которой находится файл .env
    *
    */

    public static function load($dir) {
        // Проверка существует ли файл .env
        if(!file_exists($dir . '/.env')) {
            return false;
        }

        // Установка переменных
        $lines = file($dir . '/.env');

        // echo '<pre>';
        // print_r($lines);
        // echo '</pre>'; exit;

        foreach($lines as $line) {
            putenv(trim($line));
        }

    }
}