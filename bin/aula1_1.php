<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conn.php';

use League\CLImate\CLImate;

/**
 * IV e KEY foram geradas externamente através do uso da random_bytes
 * Como a random_bytes retorna binário elas foram passadas pela bin2hex primeiro para podermos
 * usar ambas como strings "normais"
 */

define('IV', '8c3cb75c190200348d2e47affe627ead1eba88ed9dee05d0');
define('KEY', '8b780ccf57d11b9495c2311dde3ca6fcb355c3199f7fa139609454d34b5f7f82');

$cli = new CLImate();

$input = $cli->input('E-mail: ');
$email = base64_encode(
    sodium_crypto_secretbox(
        $input->prompt(), 
        hex2bin(IV), 
        hex2bin(KEY)
    )
);

$input2 = $cli->password('Senha: ');
$senha = password_hash($input2->prompt(), PASSWORD_ARGON2ID);

$now = date('Y-m-d H:i:s');

$sql = 'INSERT INTO user (email, password, created) VALUES (:email, :password, :created)';

$sth = $conn->prepare($sql);

$sth->bindParam(':email', $email, PDO::PARAM_STR);
$sth->bindParam(':password', $senha, PDO::PARAM_STR);
$sth->bindParam(':created', $created, PDO::PARAM_STR);

$sth->execute();

$conn = null;
