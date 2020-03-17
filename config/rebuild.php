<?php

return [
    /**
     * Specify what rebuilding process should run
     */

    'should_enter_maintenance_mode' => true,

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
    'should_clear_event' => true,
    'should_clear_config' => true,
    'should_clear_compiled_classes' => true,

    'should_clear_framework_bootstrap_files' => true,
    'should_cache_framework_bootstrap_files' => true,

    'should_flush_expired_password_reset_token' => true,
    'should_rediscover_packages' => true,
    'should_create_symbolic_link' => true,

    'should_self_diagnosis' => true,
    'should_run_application_test' => true,

    'should_leave_maintenance_mode' => true,

    'should_migrate_sessions_table' => true,
    'should_migrate_notifications_table' => true,
    'should_migrate_failed_queue_jobs_table' => true,
];
