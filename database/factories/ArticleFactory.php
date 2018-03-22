<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'reference_art' => $faker->sentence(),
        'type_art'  => $faker->sentence(),
        'designation'   => $faker->sentence(),
        'description'   => $faker->sentence(),
        'prix_ht_achat' => $faker->buildingNumber(),
        'prix_ht_vente' => $faker->buildingNumber(),
        'unite' => $faker->sentence(),
        'quantite'  => $faker->buildingNumber(),
        'quantite_min'  => $faker->buildingNumber(),
    ];
});
