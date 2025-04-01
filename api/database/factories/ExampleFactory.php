<?php

namespace Database\Factories;

use App\Models\Sign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Example>
 */
class ExampleFactory extends Factory
{
    protected static array $usedSignIds = [];

    public function definition(): array
    {
        return [
            'description' => fake()->text(),
            'display' => "https://www.youtube.com/embed/SRXH9AbT280",
            'sign_id' => $this->getUniqueSignId()
        ];
    }

    private function getUniqueSignId(): int
    {
        $availableSignIds = Sign::whereNotIn('id', static::$usedSignIds)->pluck('id')->toArray();

        if (empty($availableSignIds)) {
            throw new \Exception("Não há mais Sign disponíveis para associação única.");
        }

        $signId = fake()->randomElement($availableSignIds);
        static::$usedSignIds[] = $signId;

        return $signId;
    }
}
