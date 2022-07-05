<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Framework\Mailer;

use App\Shared\Application\Mailer\Mailer;
use App\Shared\Application\Mailer\Sender;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\{Email, Address};
use Twig\Environment;

final class SymfonyMailer implements Mailer
{
    private MailerInterface $mailer;
    /** @var Environment */
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig   = $twig;
    }

    public function send(string $template, array $context, Sender $sender, array $recipients, string $replyTo = null): void
    {
        $template = $this->twig->load($template);

        $subject  = $template->renderBlock('subject', $context);

        $textBody = '';

        if ($template->hasBlock('body_text')) {
            $textBody = $template->renderBlock('', $context);
        }

        $htmlBody = $template->renderBlock('body_html', $context);

        $message = new Email();
        $message->html($htmlBody)
                ->text($textBody)
                ->subject($subject)
                ->from(new Address($sender->email(), $sender->name()));

        foreach ($recipients as $recipient) {
            $message->addTo($recipient);
        }

        if ($replyTo) {
            $message->replyTo($replyTo);
        }

        $this->mailer->send($message);
    }
}
