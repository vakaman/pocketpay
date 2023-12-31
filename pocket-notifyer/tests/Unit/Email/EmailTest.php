<?php

namespace Tests\Unit\Email;

use App\Domain\Entity\Email\Body;
use App\Domain\Entity\Email\Envelope;
use App\Domain\Entity\Email\Header;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{

    public function test_can_create_a_valid_email_header(): void
    {
        $mailHeader = new Header(
            subject: 'My subject',
            from: 'from@email.com.br',
            sender: 'My sender Name',
            to: 'to@email.com.br',
            receiver: 'Receiver Name',
            money: 100,
            replyTo: 'from@email.com.br',
            date: '2023-08-10 12:25:00',
        );

        $mailArray = $mailHeader->toArray();

        $this->assertEquals([
            'subject' => 'My subject',
            'from' => 'from@email.com.br',
            'sender' => 'My sender Name',
            'to' => 'to@email.com.br',
            'receiver' => 'Receiver Name',
            'money' => 'R$ 1.00',
            'reply_to' => 'from@email.com.br',
            'date' => '2023-08-10 12:25:00',
        ], $mailArray);
    }

    public function test_can_create_a_valid_email_body(): void
    {
        $mailBody = new Body(
            message: 'Content from my message',
            contentType: 'text/plain'
        );

        $mailArray = $mailBody->toArray();

        $this->assertEquals([
            'content_type' => 'text/plain',
            'message' => 'Content from my message'
        ], $mailArray);
    }

    public function test_can_create_a_valid_email_envelope(): void
    {
        $mailHeader = new Header(
            subject: 'My subject',
            from: 'from@email.com.br',
            sender: 'My sender Name',
            to: 'to@email.com.br',
            receiver: 'Receiver Name',
            money: 100,
            replyTo: 'from@email.com.br',
            date: '2023-08-10 12:25:00',
        );

        $mailBody = new Body(
            message: 'Content from my message',
            contentType: 'text/plain'
        );

        $envelope = new Envelope($mailHeader, $mailBody);

        $headerArray = $envelope->toArray()['header']->toArray();
        $bodyArray = $envelope->toArray()['body']->toArray();

        $this->assertEquals([
            'subject' => 'My subject',
            'from' => 'from@email.com.br',
            'sender' => 'My sender Name',
            'to' => 'to@email.com.br',
            'receiver' => 'Receiver Name',
            'money' => 'R$ 1.00',
            'reply_to' => 'from@email.com.br',
            'date' => '2023-08-10 12:25:00',
        ], $headerArray);

        $this->assertEquals([
            'content_type' => 'text/plain',
            'message' => 'Content from my message'
        ], $bodyArray);
    }
}
