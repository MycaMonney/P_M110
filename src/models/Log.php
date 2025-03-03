<?php

namespace Models;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Log
{
    private static $logger;
    private static $logPath = __DIR__ . '/../logs/flag_log.log';

    private static function init()
    {
        if (!isset(self::$logger)) {
            self::ensureLogFileExists();

            try {
                self::$logger = new MonologLogger('flaglog');
                $handler = new StreamHandler(self::$logPath, MonologLogger::DEBUG);
                self::$logger->pushHandler($handler);
            } catch (\Exception $e) {
                throw new \Exception("Logging error: " . $e->getMessage());
            }
        }
    }

    private static function ensureLogFileExists(): void
    {
        $logDir = dirname(self::$logPath);

        // Vérifier si le dossier existe, sinon le créer
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }

        // Vérifier si le fichier existe, sinon le créer
        if (!file_exists(self::$logPath)) {
            file_put_contents(self::$logPath, "");
        }
    }

    public static function create(string $message, string $type = 'info'): void
    {
        self::init();
        switch ($type) {
            case 'info':
                self::$logger->info($message);
                break;
            case 'warning':
                self::$logger->warning($message);
                break;
            case 'error':
                self::$logger->error($message);
                break;
            case 'critical':
                self::$logger->critical($message);
                break;
            default:
                self::$logger->notice("Type de log inconnu : $message");
                break;
        }
    }

    public static function getAllLogs(): array
    {
        self::ensureLogFileExists(); // S'assurer que le fichier existe avant de le lire
        return file(self::$logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
}
