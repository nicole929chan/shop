<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => substr(rand(), 1, 6),
        'logo' => 'images/logo.jpg',
        'image' => null,
        'phone_number' => $faker->phoneNumber,
        'address' => $faker->address,
        'qrcode' => 'qrcode',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'start_date' => now(),
        'finish_date' => now()->addDays(10)
    ];
});
