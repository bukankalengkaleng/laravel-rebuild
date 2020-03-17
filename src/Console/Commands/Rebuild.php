<?php

namespace BukanKalengKaleng\LaravelRebuild\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;

class Rebuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the app from scratch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (app()->environment(['prod', 'production'])) {
            if ($this->confirm('You are in PRODUCTION environment. Continue?')) {
                $this->rebuildSequence();

                return;
            }
        }

        $this->rebuildSequence();
    }

    /**
     * Command operation sequence
     *
     * @return mixed
     */
    protected function rebuildSequence()
    {
        if ($this->confirm('You are about to rebuild the app from scratch. Continue?')) {
            $this->enterMaintenanceMode();

            $this->rebuildDatabaseSchema();
            $this->seedInitialData();
            $this->seedDummyData();
            $this->seedExampleData();

            $this->clearView();
            $this->clearCache();
            $this->clearRoute();
            $this->clearEvent();
            $this->clearConfig();
            $this->clearCompiledClasses();

            $this->clearFrameworkBootstrapFiles();
            $this->cacheFrameworkBootstrapFiles();

            $this->rediscoverPackages();
            $this->createSymbolicLink();
            
            $this->runSelfDiagnosis();
            $this->runApplicationTest();

            $this->leaveMaintenanceMode();

            $this->migrateSessionsTable();
            $this->migrateNotificationsTable();
            $this->migrateFailedQueueJobsTable();
        }
    }

    /**
     * Set application to Maintenance Mode
     *
     * @return void
     */
    protected function enterMaintenanceMode()
    {
        if (config('rebuild.should_enter_maintenance_mode')) {
            $this->call('down');
            $this->line('');
        }
    }

    /**
     * Rebuild database schema
     *
     * @return void
     */
    protected function rebuildDatabaseSchema()
    {
        if (config('rebuild.should_rebuild_database_schema')) {
            $this->call('migrate:fresh', ['--force' => true]);
            $this->info('Rebuilding database schema is done.');
            $this->line('');
        }
    }

    /**
     * Seeding initial data
     *
     * @return void
     */
    protected function seedInitialData()
    {
        if (config('rebuild.should_seed_initial_data')) {
            $this->composer->dumpAutoloads();

            $this->call('db:seed', ['--force' => true]);
            $this->info('Seeding initial data is done.');
            $this->line('');
        }
    }

    /**
     * Seeding dummy data
     *
     * @return void
     */
    protected function seedDummyData()
    {
        if (config('rebuild.dummy.should_seed')) {
            if ($this->confirm('Install dummy data?')) {
                try {
                    $this->call('db:seed', [
                        '--class' => config('rebuild.dummy.seeder_name'),
                        '--force' => true,
                    ]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    $this->info('Seeding dummy data is aborted.');
                    $this->line('');

                    return true;
                }

                $this->info('Seeding dummy data is done.');
                $this->line('');
            }
        }
    }

    /**
     * Seeding example data
     *
     * @return void
     */
    protected function seedExampleData()
    {
        if (config('rebuild.example.should_seed')) {
            if ($this->confirm('Install example data?')) {
                try {
                    $this->call('db:seed', [
                        '--class' => config('rebuild.example.seeder_name'),
                        '--force' => true,
                    ]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    $this->info('Seeding example data is aborted.');
                    $this->line('');

                    return true;
                }

                $this->info('Seeding example data is done.');
                $this->line('');
            }
        }
    }

    /**
     * Clear view
     *
     * @return void
     */
    protected function clearView()
    {
        if (config('rebuild.should_clear_view')) {
            $this->line('Run \'artisan view:clear\' command:');
            $this->call('view:clear');
            $this->line('');
        }
    }

    /**
     * Clear cache
     *
     * @return void
     */
    protected function clearCache()
    {
        if (config('rebuild.should_clear_cache')) {
            $this->line('Run \'artisan cache:clear\' command:');
            $this->call('cache:clear');
            $this->line('');
        }
    }

    /**
     * Clear route
     *
     * @return void
     */
    protected function clearRoute()
    {
        if (config('rebuild.should_clear_route')) {
            $this->line('Run \'artisan route:clear\' command:');
            $this->call('route:clear');
            $this->line('');
        }
    }

    /**
     * Clear event
     *
     * @return void
     */
    protected function clearEvent()
    {
        if (config('rebuild.should_clear_event')) {
            $this->line('Run \'artisan event:clear\' command:');
            $this->call('event:clear');
            $this->line('');
        }
    }

    /**
     * Clear config
     *
     * @return void
     */
    protected function clearConfig()
    {
        if (config('rebuild.should_clear_config')) {
            $this->line('Run \'artisan config:clear\' command:');
            $this->call('config:clear');
            $this->line('');
        }
    }

    /**
     * Clear compiled classes
     *
     * @return void
     */
    protected function clearCompiledClasses()
    {
        if (config('rebuild.should_clear_compiled_classes')) {
            $this->line('Run \'artisan clear-compiled\' command:');
            $this->call('clear-compiled');
            $this->line('');
        }
    }

    /**
     * Clear framework bootstrap files
     *
     * @return void
     */
    protected function clearFrameworkBootstrapFiles()
    {
        if (config('rebuild.should_clear_framework_bootstrap_files')) {
            $this->line('Run \'artisan optimize:clear\' command:');
            $this->call('optimize:clear');
            $this->line('');
        }
    }

    /**
     * Cache framework bootstrap files
     *
     * @return void
     */
    protected function cacheFrameworkBootstrapFiles()
    {
        if (config('rebuild.should_cache_framework_bootstrap_files')) {
            $this->line('Run \'artisan optimize\' command:');
            $this->call('optimize');
            $this->line('');
        }
    }

    /**
     * Rediscover packages
     *
     * @return void
     */
    protected function rediscoverPackages()
    {
        if (config('rebuild.should_rediscover_packages')) {
            $this->line('Run \'artisan package:discover\' command:');
            $this->call('package:discover');
            $this->line('');
        }
    }

    /**
     * Create symbolic link
     *
     * @return void
     */
    protected function createSymbolicLink()
    {
        if (config('rebuild.should_create_symbolic_link')) {
            $this->line('Run \'artisan storage:link\' command:');
            $this->call('storage:link');
            $this->line('');
        }
    }

    /**
     * Run BeyondCode's Laravel Self-Diagnosis command
     * more: https://github.com/beyondcode/laravel-self-diagnosis
     *
     * @return void
     */
    protected function runSelfDiagnosis()
    {
        if (config('rebuild.should_self_diagnosis')) {
            $this->line('Run \'artisan self-diagosis\' command:');
            $this->call('self-diagnosis');
            $this->line('');
        }
    }

    /**
     * Run application tests
     *
     * @return void
     */
    protected function runApplicationTest()
    {
        if (config('rebuild.should_run_application_test')) {
            $this->call('test');
            $this->line('');
        }
    }

    /**
     * Wake up application from Maintenance Mode
     *
     * @return void
     */
    protected function leaveMaintenanceMode()
    {
        if (config('rebuild.should_leave_maintenance_mode')) {
            $this->call('up');
            $this->line('');
        }
    }

    /**
     * Migrate sessions table
     *
     * @return void
     */
    protected function migrateSessionsTable()
    {
        if (config('rebuild.should_migrate_sessions_table')) {
            if ($this->confirm('Migrate sessions table?')) {
                try {
                    $this->call('session:table');
                    $this->call('migrate');
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    $this->info('Migrating sessions table is aborted.');
                    $this->line('');

                    return true;
                }

                $this->info('Migrating sessions table is done.');
                $this->line('');
            }
        }
    }

    /**
     * Migrate notifications table
     *
     * @return void
     */
    protected function migrateNotificationsTable()
    {
        if (config('rebuild.should_migrate_notifications_table')) {
            if ($this->confirm('Migrate notifications table?')) {
                try {
                    $this->call('notification:table');
                    $this->call('migrate');
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    $this->info('Migrating notifications table is aborted.');
                    $this->line('');

                    return true;
                }

                $this->info('Migrating notifications table is done.');
                $this->line('');
            }
        }
    }

    /**
     * Migrate failed queue jobs table
     *
     * @return void
     */
    protected function migrateFailedQueueJobsTable()
    {
        if (config('rebuild.should_migrate_failed_queue_jobs_table')) {
            if ($this->confirm('Migrate failed_queue_jobs table?')) {
                try {
                    $this->call('queue:failed-table');
                    $this->call('migrate');
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    $this->info('Migrating failed queue jobs table is aborted.');
                    $this->line('');

                    return true;
                }

                $this->info('Migrating failed queue jobs table is done.');
                $this->line('');
            }
        }
    }
}
