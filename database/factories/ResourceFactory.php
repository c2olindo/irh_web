<?php

use Faker\Generator as Faker;

$factory->define(App\Resource::class, function (Faker $faker) {
    return [
        'user_id'			=>	1,
        'title'				=>	$faker->sentence(3),
        'description'		=>	$faker->text,
        'license_type'		=>	'sharealike_license',
        'views'				=>	rand(0,50),
        'resource_status'	=>	'published'	
    ];
});
