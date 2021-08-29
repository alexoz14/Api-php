<?php

// COMPOSER - AUTOLOAD
require __DIR__ . '/../vendor/autoload.php';

use \App\Common\Environment;

// Загрузка переменных среды проекта
Environment::load(__DIR__ . "/../");