<?php

return [
    /**
     * Specify what rebuilding process should run
     */

    'should_set_to_maintenance_mode' => true,
    'should_rebuild_database_schema' => true,
    'should_seed_initial_data' => true,

    'dummy' => [
        'should_seed' => true,
        'seeder_name' => 'DummyDataSeeder',
    ],

    'example' => [
        'should_seed' => true,
        'seeder_name' => 'ExampleDataSeeder',
    ],

    'should_clear_view' => true,
    'should_clear_cache' => true,
    'should_clear_route' => true,
    'should_celar_config' => true,
    'should_rediscover_packages' => true,
    'should_create_symbolic_link' => true,
    'should_clear_compiled_classes' => true,
    'should_flush_expired_password_reset_token' => true,

    // Run 'laravel-self-diagnosis' by BeyondCode
    'should_self_diagnosis' => true,

    'should_wake_up_from_maintenance_mode' => true,
];
