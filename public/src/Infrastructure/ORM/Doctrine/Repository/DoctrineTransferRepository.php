<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Repository;

use App\Domain\Model\Transfer;
use App\Domain\Repository\TransferRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTransferRepository implements TransferRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist(Transfer $transfer): void
    {
        $this->em->persist($transfer);
        $this->em->flush();
    }
}
