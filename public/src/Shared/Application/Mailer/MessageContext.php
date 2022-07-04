<?php
declare(strict_types=1);

namespace App\Shared\Application\Mailer;

use function is_array;

final class MessageContext
{
    private string $template;
    private array $recipients;
    private array $parameters;
    private Sender $sender;
    private ?string $replyTo;

    public function __construct(
        string $template,
        $recipients,
        array $parameters = [],
        Sender $sender = null,
        string $replyTo = null
    ) {
        $this->template   = $template;
        $this->parameters = $parameters;
        $this->sender     = $sender;
        $this->replyTo    = $replyTo;
        $this->recipients = is_array($recipients) ? $recipients : [$recipients];
    }

    public function template(): string
    {
        return $this->template;
    }

    public function recipients(): array
    {
        return $this->recipients;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function sender(): ?Sender
    {
        return $this->sender;
    }

    public function replyTo(): ?string
    {
        return $this->replyTo;
    }
}
