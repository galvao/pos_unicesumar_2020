<?php
declare(strict_types = 1);

function teste(string $a, float $b, int $c, ?bool $d): void
{
    var_dump($d);
    return;
}

teste('a', 2, 9, null);
teste('a', 2, 9, true);
