<?php

namespace BukanKalengKaleng\LaravelRebuild\Console\Commands;

use App;
use Illuminate\Console\Command;

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
    public function __construct()
    {
        parent::__construct();
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
        $this->line('');

        $this->clearCache();
        $this->line('');

        $this->clearConfig();
        $this->line('');

        $this->clearRoute();
        $this->line('');

        $this->clearView();
        $this->line('');

        $this->flushExpiredPasswordResetToken();
        $this->line('');

        $this->clearCompiledClasses();
        $this->line('');

        $this->rediscoverPackages();
        $this->line('');

        $this->createSymbolicLink();
        $this->line('');

        $this->runSelfDiagnosis();
        $this->line('');
    }

    /**
     * Rebuild database schema
     *
     * @return void
     */
    protected function rebuildDatabaseSchema()
    {
        $this->info('[START] Rebuild database schema..........');

        $this->call('migrate:fresh');

        $this->info('[DONE ] Rebuild database schema.');
    }

    /**
     * Clear cache
     *
     * @return void
     */
    protected function clearCache()
    {
        $this->info('[START] Flush the application cache..........');

        $this->callSilent('cache:clear');

        $this->info('[DONE ] Flush the application cache.');
    }

    /**
     * Clear config
     *
     * @return void
     */
    protected function clearConfig()
    {
        $this->info('[START] Remove the configuration cache file..........');

        $this->callSilent('config:clear');

        $this->info('[DONE ] Remove the configuration cache file.');
    }

    /**
     * Clear route
     *
     * @return void
     */
    protected function clearRoute()
    {
        $this->info('[START] Remove the route cache file..........');

        $this->callSilent('route:clear');

        $this->info('[DONE ] Remove the route cache file.');
    }

    /**
     * Clear view
     *
     * @return void
     */
    protected function clearView()
    {
        $this->info('[START] Clear all compiled view files..........');

        $this->callSilent('view:clear');

        $this->info('[DONE ] Clear all compiled view files.');
    }

    /**
     * Flush expired password reset token
     *
     * @return void
     */
    protected function flushExpiredPasswordResetToken()
    {
        $this->info('[START] Flush expired password reset tokens..........');

        $this->callSilent('auth:clear-resets');

        $this->info('[DONE ] Flush expired password reset tokens.');
    }

    /**
     * Clear compiled classes
     *
     * @return void
     */
    protected function clearCompiledClasses()
    {
        $this->info('[START] Clear compiled class files..........');

        $this->callSilent('clear-compiled');

        $this->info('[DONE ] Clear compiled class files.');
    }

    /**
     * Rebuild packages manifest cache
     *
     * @return void
     */
    protected function rediscoverPackages()
    {
        $this->info('[START] Rebuild the cached package manifest..........');

        $this->callSilent('package:discover');

        $this->info('[DONE ] Rebuild the cached package manifest.');
    }

    /**
     * Create symbolic link
     *
     * @return void
     */
    protected function createSymbolicLink()
    {
        $this->info('[START] Create a symbolic link..........');

        $this->callSilent('storage:link');

        $this->info('[DONE ] Create a symbolic link.');
    }

    /**
     * Run BeyondCode's Laravel Self-Diagnosis command
     *
     * @return void
     */
    protected function runSelfDiagnosis()
    {
        $this->info('[START] Run self-diagnosis..........');

        $this->call('self-diagnosis');

        $this->info('[DONE ] Run self-diagnosis.');
    }
}
