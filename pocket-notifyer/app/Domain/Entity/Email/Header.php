<?php

namespace App\Domain\Entity\Email;

use App\Util\Sanitize;
use Illuminate\Support\Carbon;

class Header
{
    public readonly string $subject;
    public readonly string $date;
    public readonly string $from;
    public readonly string $sender;
    public readonly string $to;
    public readonly string $receiver;
    public readonly string $reply_to;

    public function __construct(
        string $subject,
        string $date,
        string $from,
        string $sender,
        string $to,
        string $receiver,
        string $reply_to,
    ) {
        $this->subject = Sanitize::string($subject);
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Sanitize::string($date));
        $this->from = new Email(Sanitize::email($from));
        $this->sender = Sanitize::string($sender);
        $this->to = new Email(Sanitize::email($to));
        $this->receiver = Sanitize::string($receiver);
        $this->reply_to = Sanitize::string($reply_to);
    }

    public function toArray()
    {
        return (array) $this;
    }
}
