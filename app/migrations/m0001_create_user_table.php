<?php

use app\core\Application;

class m0001_create_user_table {
    public function up() {
        $db = Application::$app->database;

        $sql = "CREATE TABLE IF NOT EXISTS user(
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(299) NOT NULL,
            `password` VARCHAR(299) NOT NULL,
            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )ENGINE=INNODB;";

        $db->pdo->exec($sql);
    }
    public function down() {
        $db = Application::$app->database;

        $sql = "DROP TABLE user";

        $db->pdo->exec($sql);
    }
    
}