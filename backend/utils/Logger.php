<?php
class Logger {
    public static function error(string $message): void {
        $directory = __DIR__ . '/../logs';
        if (!is_dir($directory) && !@mkdir($directory, 0770, true) && !is_dir($directory)) {
            error_log($message);
            return;
        }
        $line = '[' . gmdate('Y-m-d H:i:s') . '] ERROR ' . str_replace(["\r", "\n"], ' ', $message) . PHP_EOL;
        if (@file_put_contents($directory . '/error.log', $line, FILE_APPEND | LOCK_EX) === false) { error_log($message); }
    }
}
