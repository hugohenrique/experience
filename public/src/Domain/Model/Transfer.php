<?php
declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="transfers")
 */
class Transfer
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
    private User $payee;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private User $payer;
    /**
     * @ORM\Column(type="decimal", precision=16, scale=2)
     */
    private float $value;
    /**
     * @ORM\Column(type="datetime", name="transferred_at")
     */
    private DateTimeInterface $transferredAt;

    public function __construct(User $payee, User $payer, float $value)
    {
        $this->payee         = $payee;
        $this->payer         = $payer;
        $this->value         = $value;
        $this->transferredAt = new DateTimeImmutable();
    }
}
