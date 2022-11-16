<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'route_prefix' => env('LVG_ROUTE_PREFIX','admin'),
    'sidebar' => [
        'heading' => env("LVG_SIDEBAR_HEADING","Lvg Backend"),
    ],
    "seeder" => [
        "seed_menu" => env('LVG_SEED_MENU',true),
    ],
    'dev_modules' => explode(",", env('LVG_DEV_MODULES','LvgFields,LvgSchematics,LvgRelationships')),
    'special_modules' => explode(",", env('LVG_SPECIAL_MODULES','Core')),
    'finished_modules' => explode(",", env('LVG_FINISHED_MODULES','')),
];
