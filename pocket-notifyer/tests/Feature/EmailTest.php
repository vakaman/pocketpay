<?php

namespace Tests\Feature;

use App\Infrastructure\Http\Entity\StatusCode;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class EmailTest extends TestCase
{

    public function test_the_email_api_return_created(): void
    {
        Bus::fake();

        $emailContent = json_decode('{
            "headers": {
                "subject": "Email subject",
                "date": "2023-08-10 12:25:00",
                "from": "from@email.com.br",
                "sender": "Sender Name",
                "to": "to@email.com.br",
                "receiver": "Receiver Name",
                "reply_to": "from@email.com.br"
            },
            "body": {
                "content_type": "text/plain",
                "message": "Content from my message"
            }
        }', true);

        $response = $this->postJson('/api/email', $emailContent);

        $response->assertStatus(StatusCode::CREATED->value);
    }

    public function test_the_email_api_dispatch_job(): void
    {
        Bus::fake();

        $emailContent = json_decode('{
            "headers": {
                "subject": "Email subject",
                "date": "2023-08-10 12:25:00",
                "from": "from@email.com.br",
                "sender": "Sender Name",
                "to": "to@email.com.br",
                "receiver": "Receiver Name",
                "reply_to": "from@email.com.br"
            },
            "body": {
                "content_type": "text/plain",
                "message": "Content from my message"
            }
        }', true);

        $this->postJson('/api/email', $emailContent);

        Bus::assertDispatched(SendEmail::class);
    }
}
