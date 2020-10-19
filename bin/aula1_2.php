<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conn.php';

use League\CLImate\CLImate;

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
$senha = $input2->prompt();

$sql = 'SELECT email, password FROM user WHERE email=:email';

$sth = $conn->prepare($sql);

$sth->bindParam(':email', $email, PDO::PARAM_STR);

if (!$sth->execute()) {
    die(implode(',', $sth->errorInfo()));
}

$registro = $sth->fetchObject();

$emailGravado = $registro->email;
$senhaGravada = $registro->password;

if ($email == $emailGravado) {
    if (password_verify($senha, $senhaGravada)) {
        echo 'Bem-vindo(a)!' . PHP_EOL;
    } else {
        echo 'E-mail e/ou senha inválido(s).' . PHP_EOL;
    }
} else {
    echo 'E-mail e/ou senha inválido(s).' . PHP_EOL;
}

$conn = null;
