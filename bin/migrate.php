<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Container;

$container = new Container();
$pdo = $container->get(PDO::class);

echo "--- Database Migrations ---\n";

// Ensure the _migrations table exists
$pdo->exec("
    CREATE TABLE IF NOT EXISTS `_migrations` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `migration` VARCHAR(255) NOT NULL UNIQUE,
        `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// Get already applied migrations
$stmt = $pdo->query("SELECT migration FROM _migrations");
$appliedMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Scan for migration files
$migrationFiles = glob(__DIR__ . '/../migrations/*.sql');
sort($migrationFiles);

$count = 0;
foreach ($migrationFiles as $file) {
    $migrationName = basename($file);
    
    if (in_array($migrationName, $appliedMigrations)) {
        continue;
    }

    echo "Applying: {$migrationName}\n";
    
    try {
        $sql = file_get_contents($file);
        
        // PDO doesn't support multiple queries in exec() easily if they contain DELIMITER or similar
        // but for standard DDL it works if we use the right settings.
        // Given we use MySQL, we can execute the whole script.
        $pdo->exec($sql);
        
        $logStmt = $pdo->prepare("INSERT INTO _migrations (migration) VALUES (?)");
        $logStmt->execute([$migrationName]);
        
        $count++;
        echo "Successfully applied: {$migrationName}\n";
    } catch (\PDOException $e) {
        echo "ERROR applying {$migrationName}: " . $e->getMessage() . "\n";
        exit(1);
    }
}

if ($count === 0) {
    echo "No pending migrations found.\n";
} else {
    echo "Total migrations applied: {$count}\n";
}

echo "--- Migration Completed ---\n";
