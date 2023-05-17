<?php

namespace App\Tests;

use App\Service\EmailService;
use App\Service\SlackEmailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;

class SlackEmailServiceTest extends TestCase
{
    public function testSendEmailToSlack(): void
    {
        $transport = $this->createMock(TransportInterface::class);
        $transport->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(RawMessage::class));

        $mailer = new Mailer($transport);
        $emailService = new EmailService($mailer);
        $slackEmailService = new SlackEmailService($emailService, 'slack-channel@mailclark.ai');

        $slackEmailService->sendEmailToSlack('Hello', 'Hello, Slack channel');
    }
}