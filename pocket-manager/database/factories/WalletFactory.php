<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid as UuidGenerator;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        return [
            'id' => (UuidGenerator::uuid4())->toString(),
            'money' => 0,
            'main' => false
        ];
    }

    public function main($state): Factory
    {
        return $this->state(function (array $attributes) use ($state) {
            return [
                'main' => $state,
            ];
        });
    }
}
