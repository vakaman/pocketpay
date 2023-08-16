<?php

namespace App\Domain\Entity\Email;

use App\Domain\Entity\Currency\Money;
use App\Util\Sanitize;
use Illuminate\Support\Carbon;

class Header
{
    public readonly string $subject;
    public readonly string $from;
    public readonly string $sender;
    public readonly string $to;
    public readonly string $receiver;
    public readonly string $money;
    public readonly ?string $reply_to;
    public readonly ?string $date;

    public function __construct(
        string $subject,
        string $from,
        string $sender,
        string $to,
        string $receiver,
        int $money,
        ?string $reply_to,
        ?string $date,
    ) {
        $this->subject = Sanitize::string($subject);
        $this->from = new Email(Sanitize::email($from));
        $this->sender = Sanitize::string($sender);
        $this->to = new Email(Sanitize::email($to));
        $this->receiver = Sanitize::string($receiver);
        $this->money = (new Money($money))->toReal();
        $this->reply_to = Sanitize::string($reply_to) ?? $this->from;
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Sanitize::string($date));
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
