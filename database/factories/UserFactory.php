<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {

    return [
        'identificacion'=>'99031106423',
        'nombres' => 'Camilo Andres',
        'apellidos' => ' Colon Cañizares',
        'email' => $faker->unique()->safeEmail,
        'estado' => 'ACTIVO',
        'password' => bcrypt('secret'), // password
        'remember_token' => Str::random(10),
    ];
});
