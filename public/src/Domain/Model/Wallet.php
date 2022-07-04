<?php
declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\InsufficientFundsException;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * @ORM\Entity()
 * @ORM\Table(name="wallets")
 */
class Wallet
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue("AUTO")
     */
    private int $id;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private User $user;
    /**
     * @ORM\Column(type="decimal", precision=16, scale=2)
     */
    private float $balance;

    public function __construct(User $user, float $balance = 0)
    {
        $this->user    = $user;
        $this->balance = $balance;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function balance(): float
    {
        return $this->balance;
    }

    public function subBalance(float $value): void
    {
        if ($this->balance < $value) {
            throw new InsufficientFundsException('Você não tem crédito suficiente para esta operação.');
        }

        $this->balance = $this->balance - $value;
    }
}
