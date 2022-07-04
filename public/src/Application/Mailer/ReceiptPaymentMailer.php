<?php
declare(strict_types=1);

namespace App\Application\Mailer;

use App\Domain\Repository\UserRepository;
use App\Shared\Application\Mailer\MessageContext;
use App\Shared\Application\Mailer\Sender;

final class ReceiptPaymentMailer
{
    public function __construct(
        private UserRepository $repository, 
        private string $template,
        private ?Sender $sender = null
    ) {
        $this->repository = $repository;
        $this->template   = $template;
        $this->sender     = $sender;
    }

    public function send(array $parameters): MessageContext
    {
        $parameters['user'] = $this->repository->findById($parameters['payeeId']);

        return new MessageContext(
            $this->template,
            $parameters['email'],
            $parameters,
            $this->sender
        );
    }
}