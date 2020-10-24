<?php
declare(strict_types = 1);

namespace Application\TableGateway;

class CRUD
{
    public $pdo;
    public $table;

    public function __construct(\PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function create(object $model)
    {
        $cols = '';
        $vals = '';


        foreach (get_object_vars($model) as $col => $val) {
            if ($col != 'id') {
                $cols .= $col . ',';
                $vals .= "'$val'" . ',';
            }
        }

        $cols = substr($cols, 0, strlen($cols) - 1);
        $vals = substr($vals, 0, strlen($vals) - 1);

        $sql = 'INSERT INTO ' . $this->table . '(' . $cols . ') VALUES (' . $vals . ')';

        $sth = $this->pdo->prepare($sql);
        $sth->execute();

        return $sql;
    }
}
