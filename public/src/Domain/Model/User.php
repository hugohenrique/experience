<?php
declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[ORM\Table(name: "users")]
#[UniqueEntity(fields: ['cpf', 'email'])]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", length: 11)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;
    #[ORM\Id(type: "string")]
    private string $name;
    #[ORM\Id(type: "string", unique: true)]
    private string $cpf;
    #[ORM\Id(type: "string", unique: true)]
    private string $email;
    #[ORM\Id(type: "string")]
    private string $password;

    public function __construct(string $name, string $cpf, string $email, string $password)
    {
        $this->name     = $name;
        $this->cpf      = $cpf;
        $this->email    = $email;
        $this->password = $password;
    }

    public function id(): int
    {
        return $this->id;
    }
}
