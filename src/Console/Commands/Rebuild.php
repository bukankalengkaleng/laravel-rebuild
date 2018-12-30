<?php

namespace BukanKalengKaleng\LaravelRebuild\Console\Commands;

use App;
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
        if (App::environment(['prod', 'production'])) {
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
        $this->line('');

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
    }

    /**
     * Rebuild database schema
     *
     * @return void
     */
    protected function rebuildDatabaseSchema()
    {
        if (config('rebuild.should_rebuild_database_schema')) {
            $this->info('[START] Rebuild database schema..........');

            $this->callSilent('migrate:fresh', ['--force' => true]);

            $this->info('[DONE ] Rebuild database schema.');
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

            $this->info('[START] Install initial data..........');

            $this->call('db:seed', ['--force' => true]);

            $this->info('[DONE ] Install initial data.');
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
                $this->info('[START] Install dummy data..........');

                try {
                    $this->call('db:seed', [
                        '--class' => config('rebuild.dummy.seeder_name'),
                        '--force' => true,
                    ]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    $this->info('[ABORT] Install dummy data.');
                    $this->line('');

                    return true;
                }

                $this->info('[DONE ] Install dummy data.');
                $this->line('');
            }
        }
    }

    protected function seedExampleData()
    {
        if (config('rebuild.example.should_seed')) {
            if ($this->confirm('Install example data?')) {
                $this->info('[START] Install example data..........');

                $this->call('db:seed', [
                    '--class' => config('rebuild.example.seeder_name'),
                    '--force' => true,
                ]);

                $this->info('[DONE ] Install example data.');
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
            $this->info('[START] Flush the application cache..........');

            $this->callSilent('cache:clear');

            $this->info('[DONE ] Flush the application cache.');
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
            $this->info('[START] Remove the configuration cache file..........');

            $this->callSilent('config:clear');

            $this->info('[DONE ] Remove the configuration cache file.');
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
            $this->info('[START] Remove the route cache file..........');

            $this->callSilent('route:clear');

            $this->info('[DONE ] Remove the route cache file.');
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
            $this->info('[START] Clear all compiled view files..........');

            $this->callSilent('view:clear');

            $this->info('[DONE ] Clear all compiled view files.');
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
            $this->info('[START] Flush expired password reset tokens..........');

            $this->callSilent('auth:clear-resets');

            $this->info('[DONE ] Flush expired password reset tokens.');
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
            $this->info('[START] Clear compiled class files..........');

            $this->callSilent('clear-compiled');

            $this->info('[DONE ] Clear compiled class files.');
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
            $this->info('[START] Rebuild the cached package manifest..........');

            $this->callSilent('package:discover');

            $this->info('[DONE ] Rebuild the cached package manifest.');
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
            $this->info('[START] Create a symbolic link..........');

            $this->callSilent('storage:link');

            $this->info('[DONE ] Create a symbolic link.');
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
            $this->info('[START] Run self-diagnosis..........');

            $this->call('self-diagnosis');

            $this->info('[DONE ] Run self-diagnosis.');
            $this->line('');
        }
    }
}
