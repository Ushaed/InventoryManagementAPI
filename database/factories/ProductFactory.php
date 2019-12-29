<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Product::class, function (Faker $faker) {
    $name = $faker->unique()->name;
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'category_id' =>random_int(1,5),
        'brand_id' => random_int(1,5),
        'status' =>'1',
        'description' => $faker->text,
        'price' => 3000,
    ];
});
