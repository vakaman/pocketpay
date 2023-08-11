<?php

namespace Tests\Unit;

use App\Domain\Entity\Email\Body;
use App\Domain\Entity\Email\Envelope;
use App\Domain\Entity\Email\Header;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{

    public function test_can_create_a_valid_email_header(): void
    {
        $mailHeader = new Header(
            'My subject',
            '2023-08-10 12:25:00',
            'from@email.com.br',
            'to@email.com.br',
            'My sender Name',
            'from@email.com.br'
        );

        $mailArray = (array) $mailHeader;

        $this->assertEquals([
            'subject' => 'My subject',
            'date' => '2023-08-10 12:25:00',
            'from' => 'from@email.com.br',
            'to' => 'to@email.com.br',
            'sender' => 'My sender Name',
            'reply_to' => 'from@email.com.br'
        ], $mailArray);
    }

    public function test_can_create_a_valid_email_body(): void
    {
        $mailBody = new Body(
            'text/plain',
            'Content from my messageContent from my message'
        );

        $mailArray = (array) $mailBody;

        $this->assertEquals([
            'content_type' => 'text/plain',
            'message' => 'Content from my messageContent from my message'
        ], $mailArray);
    }

    public function test_can_create_a_valid_email_envelope(): void
    {
        $mailHeader = new Header(
            'My subject',
            '2023-08-10 12:25:00',
            'from@email.com.br',
            'to@email.com.br',
            'My sender Name',
            'from@email.com.br'
        );

        $mailBody = new Body(
            'text/plain',
            'Content from my messageContent from my message'
        );

        $envelope = new Envelope($mailHeader, $mailBody);

        $headerArray = $envelope->toArray()['header']->toArray();
        $bodyArray = $envelope->toArray()['body']->toArray();

        $this->assertEquals([
            'subject' => 'My subject',
            'date' => '2023-08-10 12:25:00',
            'from' => 'from@email.com.br',
            'to' => 'to@email.com.br',
            'sender' => 'My sender Name',
            'reply_to' => 'from@email.com.br'
        ], $headerArray);

        $this->assertEquals([
            'content_type' => 'text/plain',
            'message' => 'Content from my messageContent from my message'
        ], $bodyArray);
    }
}
