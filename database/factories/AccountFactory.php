<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Config;


class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        $phoneNumber = $this->faker->numerify('###########');
        $phoneNumberWithoutHyphen = str_replace('-', '', $phoneNumber);

        $postCode = $this->faker->numerify('#######');
        $postCodeWithoutHyphen = str_replace('-', '', $postCode);

        $adminLevels = array_keys(Config::get('const.admin_level'));
        $prefectures = array_keys(Config::get('const.prefecture'));

        return [
            'name' => $this->faker->name,
            'sub_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'tel' => $phoneNumberWithoutHyphen,
            'post_code' => $postCodeWithoutHyphen,
            'prefecture' => $this->faker->randomElement($prefectures),
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'comment' => 'これは備考欄です。',
            'admin_level' => $this->faker->randomElement($adminLevels),
        ];
    }
}
