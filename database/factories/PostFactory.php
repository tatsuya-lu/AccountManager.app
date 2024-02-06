<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Config;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $phoneNumber = $this->faker->numerify('###########');
        $phoneNumberWithoutHyphen = str_replace('-', '', $phoneNumber);

        return [
            'company' => $this->faker->company,
            'name' => $this->faker->name,
            'tel' => $phoneNumberWithoutHyphen,
            'email' => $this->faker->unique()->safeEmail,
            'birthday' => $this->faker->date,
            'gender' => $this->faker->randomElement(array_keys(Config::get('const.gender'))),
            'profession' => $this->faker->randomElement(array_keys(Config::get('const.profession'))),
            'body' => 'これはお問い合わせの本文です。',
            'status' => $this->faker->randomElement(array_keys(Config::get('const.status'))),
            'comment' => 'これは備考欄です。',
        ];
    }
}
