<?php
$dsn = 'mysql:host=localhost;dbname=teste';

try {
    $conn = new PDO($dsn, 'root', '12qw09po');
} catch (PDOException $e) {
    die('erro de conexão: ' . $e->getMessage());
}
