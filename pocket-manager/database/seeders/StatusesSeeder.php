<?php

namespace Database\Seeders;

use App\Domain\Enum\TransactionStatusEnum;
use App\Models\Statuses;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (TransactionStatusEnum::cases() as $status) {
            Statuses::firstOrCreate(
                ['name' => $status->name],
                [
                    'id' => $status->value,
                    'name' => $status->name,
                ]
            );
        }
    }
}
