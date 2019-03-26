<?php
/**
 * Created by PhpStorm.
 * User: ifiring
 * Date: 2018/12/28
 * Time: 10:22 PM
 */

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Article::class, function (Faker $faker) {
    $content = $faker->text(5000);
    return [
        'title' => $faker->sentence(),
        'description' => $faker->sentence(),
        'content_raw' => $content,
        'content_html' => $content,
    ];
});