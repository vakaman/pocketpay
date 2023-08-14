<?php

namespace App\Infrastructure\Http\Entity\Notification;

use App\Domain\ValueObject\Email;
use App\Util\Sanitize;
use Illuminate\Support\Carbon;

class Headers
{
    public readonly string $subject;
    public readonly string $from;
    public readonly string $sender;
    public readonly string $to;
    public readonly string $receiver;
    public readonly ?string $reply_to;
    public readonly ?string $date;

    public function __construct(
        string $subject,
        string $from,
        string $sender,
        string $to,
        string $receiver,
        ?string $reply_to = null,
        ?string $date = null,
    ) {
        $this->subject = Sanitize::string($subject);
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Sanitize::string($date));
        $this->from = new Email($from);
        $this->sender = Sanitize::string($sender);
        $this->to = new Email($to);
        $this->receiver = Sanitize::string($receiver);
        $this->reply_to = Sanitize::string($reply_to) ?? $this->from;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
