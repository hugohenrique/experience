<?php
declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=36)
 * @ORM\DiscriminatorMap({"regular"="RegularUser", "shopkeeper"="Shopkeeper"})
 * @UniqueEntity(fields={"cpf", "email"})
 */
abstract class User
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue("AUTO")
     */
    protected int $id;
    /**
     * @ORM\Column(type="string")
     */
    protected string $name;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $cpf;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $email;
    /**
     * @ORM\Column(type="string")
     */
    protected string $password;

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

    public function email(): string
    {
        return $this->email;
    }
}
