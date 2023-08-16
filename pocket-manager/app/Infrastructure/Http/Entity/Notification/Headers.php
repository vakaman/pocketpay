<?php

namespace App\Infrastructure\Http\Entity\Notification;

use App\Domain\Entity\Currency\Money;
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
    public readonly Money $money;
    public readonly ?Email $reply_to;
    public readonly Carbon $date;

    public function __construct(
        string $subject,
        Email $from,
        Name $sender,
        Email $to,
        Name $receiver,
        Money $money,
        ?string $reply_to = null,
        ?Carbon $date = null,
    ) {
        $this->subject = Sanitize::string($subject);
        $this->from = $from;
        $this->sender = $sender;
        $this->to = $to;
        $this->receiver = $receiver;
        $this->money = $money;
        $this->reply_to = !is_null($reply_to) ? Sanitize::string($reply_to) : $this->from;
        $this->date = $date ?? Carbon::now();
    }

    public function toArray(): array
    {
        return [
            'subject' => $this->subject,
            'from' => $this->from->value,
            'sender' => $this->sender->value,
            'to' => $this->to->value,
            'receiver' => $this->receiver->value,
            'money' => $this->money->toInt(),
            'reply_to' => $this->reply_to->value,
            'date' => $this->date->format('Y-m-d H:i:s')
        ];
    }
}
