<?php

use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Dotenv\Dotenv;

define('TESTS_DIR', __DIR__);
define('BUILD_DIR', __DIR__ . '/../build');

/**
 * Returns database connection (PDO).
 *
 * Connection is shared,
 * i.e. this function don't creates new connection each time.
 *
 * Connection is created using following environment variables:
 *  - DB_DSN
 *  - DB_NAME (does not required for SQLite)
 *  - DB_USER
 *  - DB_PASSWORD
 * @return PDO
 */
function db()
{
    static $db;
    if ($db === null) {
        $dsn = getenv('DB_DSN');
        $db = new PDO(
            $dsn,
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => 1
            ]
        );
    }
    return $db;
}

/**
 * @return \Doctrine\DBAL\Connection
 */
function doctrine_connection()
{
    return new \Doctrine\DBAL\Connection(
        [
            'pdo' => db()
        ],
        new Driver
    );
}

function create_database()
{
    $fileName = str_replace('sqlite:','', getenv('DB_DSN'));
    if (file_exists($fileName)) {
        return;
    }
    $pdo = db();
    $sql = file_get_contents(TESTS_DIR . '/fixtures/db.sql');
    foreach (explode(';', $sql) as $query) {
        if (!trim($query)) {
            continue;
        }
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        } catch (\Exception $e) {
            echo $e;
            echo PHP_EOL, 'Query: ', $query;
            die();
        }
    }
}

function array_data()
{
    static $data;
    if ($data === null) {
        $data = include TESTS_DIR . '/fixtures/users.php';
    }
    return $data;
}

function prepare_eloquent() {
    $capsule = new Illuminate\Database\Capsule\Manager;
    $fileName = str_replace('sqlite:','', getenv('DB_DSN'));
    $capsule->addConnection([
        'driver'   => 'sqlite',
        'database' => $fileName,
        'prefix'   => '',
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
// set timezone for timestamps etc
    date_default_timezone_set('UTC');
}

$dotEnv = new Dotenv(TESTS_DIR);
$dotEnv->load();
create_database();
