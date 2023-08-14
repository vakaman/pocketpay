<?php

namespace App\Infrastructure\Http\Entity\Notification;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Util\Sanitize;
use Illuminate\Support\Carbon;

class Headers
{
    public readonly string $subject;
    public readonly Email $from;
    public readonly Name $sender;
    public readonly Email $to;
    public readonly Name $receiver;
    public readonly ?string $reply_to;
    public readonly ?string $date;

    public function __construct(
        string $subject,
        Email $from,
        Name $sender,
        Email $to,
        Name $receiver,
        ?string $reply_to = null,
        ?string $date = null,
    ) {
        $this->subject = Sanitize::string($subject);
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Sanitize::string($date));
        $this->from = $from;
        $this->sender = $sender;
        $this->to = $to;
        $this->receiver = $receiver;
        $this->reply_to = Sanitize::string($reply_to) ?? $this->from;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
