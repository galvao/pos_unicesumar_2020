<?php
declare(strict_types = 1);

namespace Application\Model;

class User
{
    public int $id;
    public string $email;
    public string $password;
    public string $created;

    public function __construct(int $id, string $email, string $password, \DateTime $created)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->created = $created->format('Y-m-d H:i:s');
    }
}
