<?php

namespace App\Tests;

use App\Service\EmailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;

class EmailServiceTest extends TestCase
{
    public function testSendEmail(): void
    {
        $transport = $this->createMock(TransportInterface::class);
        $transport->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(RawMessage::class));

        $mailer = new Mailer($transport);
        $emailService = new EmailService($mailer);
        $emailService->sendEmail('test@example.com', 'Hello', 'Hello, world!');
    }
}