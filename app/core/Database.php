<?php
namespace app\core;

use PDO;

class Database {

    public PDO $pdo;

    public function __construct(array $config) {

        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
    }   

    public function applyMigrations() {
        $this->createMigrationTable();
        $applieMigrations = $this->getAppliedMigrations();


        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR."/migrations");
        $toApplyMigrations = array_diff($files, $applieMigrations);

        foreach($toApplyMigrations as $migration) {
            if($migration == "." || $migration == "..") continue;

            require_once Application::$ROOT_DIR."/migrations/$migration";

            $className = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className();
            $instance->up();

            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied.");
        }
    }

    public function createMigrationTable() {
        $sql = "CREATE TABLE IF NOT EXISTS migration(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )ENGINE=INNODB;";

        $this->pdo->exec($sql);
    }

    public function getAppliedMigrations() {
        $sql = "SELECT migration FROM migration";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations) {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));

        $sql = "INSERT INTO migration(migration) VALUES $str";
        
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    protected function log($message) {
        echo "[".date("Y-m-d H:i:s")."] - ".$message.PHP_EOL;
    }
}