<?php

namespace App\Domain\Entity\Email;

use App\Util\Sanitize;
use Illuminate\Support\Carbon;

class Header
{
    public readonly string $subject;
    public readonly string $date;
    public readonly string $from;
    public readonly string $to;
    public readonly string $sender;
    public readonly string $reply_to;

    public function __construct(
        string $subject,
        string $date,
        string $from,
        string $to,
        string $sender,
        string $reply_to,
    ) {
        $this->subject = Sanitize::string($subject);
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Sanitize::string($date));
        $this->from = new Email(Sanitize::email($from));
        $this->to = new Email(Sanitize::email($to));
        $this->sender = Sanitize::string($sender);
        $this->reply_to = Sanitize::string($reply_to);
    }

    public function toArray()
    {
        return (array) $this;
    }
}
