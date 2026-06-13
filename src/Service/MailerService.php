<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $noReplyEmail,
        private readonly string $replyEmail,
        private readonly string $fromName,
    ) {}

    private function createEmail(string $to, string $subject, string $content): Email
    {
        return (new Email())
            ->from(new Address($this->noReplyEmail, $this->fromName))
            ->replyTo($this->replyEmail)
            ->to($to)
            ->subject($subject)
            ->text($content)
            ->html('<p>' . $content . '</p>');
    }

    private function send(Email $email): void
    {
        $this->mailer->send($email);
    }

    public function sendEmail(string $to, string $subject, string $content, ?string $fromName = null): void
    {
        $fromName = $fromName ?? $this->fromName;

        $email = $this->createEmail($to, $subject, $content);
        $this->send($email);
    }
}
