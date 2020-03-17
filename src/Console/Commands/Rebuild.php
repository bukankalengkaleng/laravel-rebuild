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
            $this->setToMaintenanceMode();
            $this->rebuildDatabaseSchema();
            $this->seedInitialData();
            $this->seedDummyData();
            $this->seedExampleData();
            $this->clearCache();
            $this->clearConfig();
            $this->clearRoute();
            $this->clearView();
            $this->flushExpiredPasswordResetToken();
            $this->clearCompiledClasses();
            $this->rediscoverPackages();
            $this->createSymbolicLink();
            $this->runSelfDiagnosis();
            $this->wakeUpFromMaintenanceMode();
        }
    }

    /**
     * Rebuild database schema
     *
     * @return void
     */
    protected function setToMaintenanceMode()
    {
        if (config('rebuild.should_set_to_maintenance_mode')) {
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
     * Clear cache
     *
     * @return void
     */
    protected function clearCache()
    {
        if (config('rebuild.should_clear_cache')) {
            $this->line('Run artisan \'cache:clear\' command:');
            $this->call('cache:clear');
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
        if (config('rebuild.should_celar_config')) {
            $this->line('Run artisan \'config:clear\' command:');
            $this->call('config:clear');
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
            $this->line('Run artisan \'route:clear\' command:');
            $this->call('route:clear');
            $this->line('');
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
            $this->line('Run artisan \'view:clear\' command:');
            $this->call('view:clear');
            $this->line('');
        }
    }

    /**
     * Flush expired password reset token
     *
     * @return void
     */
    protected function flushExpiredPasswordResetToken()
    {
        if (config('rebuild.should_flush_expired_password_reset_token')) {
            $this->line('Run artisan \'auth:clear-resets\' command:');
            $this->call('auth:clear-resets');
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
            $this->line('Run artisan \'clear-compiled\' command:');
            $this->call('clear-compiled');
            $this->line('');
        }
    }

    /**
     * Rebuild packages manifest cache
     *
     * @return void
     */
    protected function rediscoverPackages()
    {
        if (config('rebuild.should_rediscover_packages')) {
            $this->line('Run artisan \'package:discover\' command:');
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
            $this->line('Run artisan \'storage:link\' command:');
            $this->call('storage:link');
            $this->line('');
        }
    }

    /**
     * Run BeyondCode's Laravel Self-Diagnosis command
     *
     * @return void
     */
    protected function runSelfDiagnosis()
    {
        if (config('rebuild.should_self_diagnosis')) {
            $this->line('Run artisan \'self-diagosis\' command:');
            $this->call('self-diagnosis');
            $this->line('');
        }
    }

    /**
     * Rebuild database schema
     *
     * @return void
     */
    protected function wakeUpFromMaintenanceMode()
    {
        if (config('rebuild.should_wake_up_from_maintenance_mode')) {
            $this->call('up');
            $this->line('');
        }
    }
}
