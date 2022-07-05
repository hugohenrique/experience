<?php
declare(strict_types=1);

namespace App\Shared\Application\Mailer;

interface Mailer
{
    public function send(
        string $template,
        array $context,
        Sender $sender,
        array $recipients,
        string $replyTo = null
    ): void;
}
