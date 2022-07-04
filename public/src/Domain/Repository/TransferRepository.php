<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Transfer;

interface TransferRepository
{
    public function persist(Transfer $transfer): void;
}