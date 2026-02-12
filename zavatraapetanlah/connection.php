<?php
$host = 'localhost';
$dbname = 'echange_revision';
$username = 'postgres';  
$password = '';
$port = '5432';          

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    
    $pdo = new PDO($dsn, $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
