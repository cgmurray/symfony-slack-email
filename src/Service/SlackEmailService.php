<?php

namespace App\Service;

class SlackEmailService
{
    private $emailService;
    private $slackEmail;

    public function __construct(EmailService $emailService, string $slackEmail)
    {
        $this->emailService = $emailService;
        $this->slackEmail = $slackEmail;
    }

    public function sendEmailToSlack(string $subject, string $body): void
    {
        $this->emailService->sendEmail($this->slackEmail, $subject, $body);
    }
}