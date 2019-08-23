<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Activity;
use App\Models\Member;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'member_id' => factory(Member::class)->create()->id,
        'points' => 2,
        'description' => $faker->paragraph,
        'image_path' => $faker->imageUrl,
        'activity_start' => today(),
        'activity_end' => today()->addDays(3)
    ];
});
