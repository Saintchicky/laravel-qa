<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        // rand genère des nombres aléatoires donc rand 5 à 10
        'title'=>rtrim($faker->sentence(rand(5,10),".")),//enlève les points 
        'body'=>$faker->paragraph(rand(3,7),true),// avec des sauts de lignes
        'views'=>rand(0,10),
        'answers'=>rand(0,10),
        'votes'=>rand(-3,10)
    ];
});
