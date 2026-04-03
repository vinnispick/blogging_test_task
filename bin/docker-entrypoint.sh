#!/bin/bash
set -e

# --- Runtime Directory Preparation ---
# Ensure essential directories exist and are writable by the web server (www-data)
# even when host volumes are mounted.
echo "Preparing essential directories..."
mkdir -p logs templates_c cache
chmod -R 777 logs templates_c cache
chown -R www-data:www-data logs templates_c cache

# Wait for MySQL to be ready
echo "Waiting for database to be ready..."
php -r '
$max_tries = 30;
$retry_delay = 2;
$connected = false;

// We need to load autoloader to use Dotenv if needed, 
// but here we just check for reachability using env vars already set by Docker.
for ($i = 0; $i < $max_tries; $i++) {
    try {
        $host = getenv("DB_HOST") ?: "db";
        $port = getenv("DB_PORT") ?: "3306";
        $db   = getenv("DB_NAME") ?: "blog_db";
        $user = getenv("DB_USER") ?: "root";
        $pass = getenv("DB_PASSWORD") ?: "root";
        
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
        $connected = true;
        break;
    } catch (Exception $e) {
        echo "Database not ready yet... (" . ($i + 1) . "/$max_tries)\n";
        sleep($retry_delay);
    }
}

if (!$connected) {
    echo "Could not connect to database. Exiting.\n";
    exit(1);
}
echo "Database is ready!\n";
'

# Run migrations
echo "Running migrations..."
php bin/migrate.php

# Start Apache
echo "Starting Apache..."
exec apache2-foreground
