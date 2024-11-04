<?php
// Configuration de la base de données
define('DB_HOST', 'localhost'); 
define('DB_USER', 'dev434');
define('DB_PASSWORD', 'dev434');
define('DB_NAME', 'cours343');
define('DB_PORT', 3306); 

// Fonction pour établir la connexion à la base de données avec PDO
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8";
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
