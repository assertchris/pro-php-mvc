<?php

namespace Framework\Email\Driver;

use Framework\Email\Exception\CompositionException;
use Postmark\Transport;
use Swift_Mailer;
use Swift_Message;

class PostmarkDriver implements Driver
{
    private array $config;
    private Swift_Mailer $mailer;
    private string $to;
    private string $subject;
    private string $text;
    private string $html;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function to(string $to): static
    {
        $this->to = $to;
        return $this;
    }

    public function subject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function html(string $html): static
    {
        $this->html = $html;
        return $this;
    }

    public function send(): void
    {
        if (!isset($this->to)) {
            throw new CompositionException('to required');
        }

        if (!isset($this->text) && !isset($this->html)) {
            throw new CompositionException('text or email required');
        }

        $fromName = $this->config['from']['name'];
        $fromEmail = $this->config['from']['email'];

        $subject = $this->subject ?? "Message from {$fromName}";

        $message = (new Swift_Message($subject))
            ->setFrom([$fromEmail => $fromName])
            ->setTo([$this->to]);

        if (isset($this->text) && !isset($this->html)) {
            $message->setBody($this->text, 'text/plain');
        }

        if (!isset($this->text) && isset($this->html)) {
            $message->setBody($this->html, 'text/html');
        }

        if (isset($this->text, $this->html)) {
            $message
                ->setBody($this->html, 'text/html')
                ->addPart($this->text, 'text/plain');
        }

        $this->mailer()->send($message);
    }

    private function mailer()
    {
        if (!isset($this->mailer)) {
            $transport = new Transport($this->config['token']);
            $this->mailer = new Swift_Mailer($transport);
        }

        return $this->mailer;
    }
}
