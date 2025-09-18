<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Kernel\Database;

$pdo = Database::getInstance();

$migrationsPath = __DIR__ . '/../migrations';

$files = glob($migrationsPath . '/*.sql');
if (empty($files)) {
    echo "Нет миграций для выполнения.\n";
    exit(0);
}

foreach ($files as $file) {
    echo "Выполняю миграцию: " . basename($file) . "\n";
    $sql = file_get_contents($file);

    try {
        $pdo->exec($sql);
        echo "✅ Миграция успешно выполнена\n";
    } catch (PDOException $e) {
        echo "❌ Ошибка миграции: " . $e->getMessage() . "\n";
    }
}