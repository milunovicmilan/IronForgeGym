<?php
class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            $path = __DIR__ . '/config.php';

            if (!is_file($path)) {
                throw new RuntimeException(
                    'Copy config.example.php to config.php ' .
                    'and configure the database.'
                );
            }

            $c = require $path;

            self::$connection = new PDO(
                "mysql:host={$c['host']};" .
                "port={$c['port']};" .
                "dbname={$c['database']};charset=utf8mb4",
                $c['username'],
                $c['password'],
                [
                    PDO::ATTR_ERRMODE =>
                        PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                        PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }

        return self::$connection;
    }
}