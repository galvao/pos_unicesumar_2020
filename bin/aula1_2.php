<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conn.php';

use League\CLImate\CLImate;

define('IV', '8c3cb75c190200348d2e47affe627ead1eba88ed9dee05d0');
define('KEY', '8b780ccf57d11b9495c2311dde3ca6fcb355c3199f7fa139609454d34b5f7f82');

$cli = new CLImate();

$input = $cli->input('E-mail: ');
$emailRaw = $input->prompt();

$email = base64_encode(
    sodium_crypto_secretbox(
        $emailRaw,
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
    var_dump($sth->debugDumpParams());
    die(implode(',', $sth->errorInfo()));
}

$registro = $sth->fetchObject();

function auth($email, $senha, $registro)
{
    if ($registro != false) {
        $emailGravado = $registro->email;
        $senhaGravada = $registro->password;

        if ($email == $emailGravado) {
            if (password_verify($senha, $senhaGravada)) {
                /**
                 * Exemplo de descriptografia com a Sodium
                 *
                 * $emailRevelado = sodium_crypto_secretbox_open(
                 *   base64_decode($email),
                 *   hex2bin(IV), 
                 *   hex2bin(KEY)
                 );

                var_dump($emailRevelado);*/

                return true;
            } else {
                return false;
            }
        } else {
                return false;
        }
    } else {
        return false;
    }
}

if (auth($email, $senha, $registro) == true) {
    echo 'Bem-vindo(a).';
} else {
    echo 'O e-mail ' , $emailRaw . ' não existe ou a senha está incorreta.';
}

echo PHP_EOL;

$conn = null;
