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
        $this->call('migrate:fresh');
        $this->line('');

        $this->info('[START] Flush the application cache..........');
        $this->callSilent('cache:clear');
        $this->info('[DONE ] Flush the application cache.');
        $this->line('');

        $this->info('[START] Remove the configuration cache file..........');
        $this->callSilent('config:clear');
        $this->info('[DONE ] Remove the configuration cache file.');
        $this->line('');

        $this->info('[START] Remove the route cache file..........');
        $this->callSilent('route:clear');
        $this->info('[DONE ] Remove the route cache file.');
        $this->line('');

        $this->info('[START] Clear all compiled view files..........');
        $this->callSilent('view:clear');
        $this->info('[DONE ] Clear all compiled view files.');
        $this->line('');

        $this->info('[START] Flush expired password reset tokens..........');
        $this->callSilent('auth:clear-resets');
        $this->info('[DONE ] Flush expired password reset tokens.');
        $this->line('');

        $this->info('[START] Clear compiled class files..........');
        $this->callSilent('clear-compiled');
        $this->info('[DONE ] Clear compiled class files.');
        $this->line('');

        $this->info('[START] Rebuild the cached package manifest..........');
        $this->callSilent('package:discover');
        $this->info('[DONE ] Rebuild the cached package manifest.');
        $this->line('');

        $this->info('[START] Create a symbolic link..........');
        $this->callSilent('storage:link');
        $this->info('[DONE ] Create a symbolic link.');
        $this->line('');

        $this->runSelfDiagnosis();
        $this->line('');
    }

    /**
     * Run BeyondCode's Laravel Self-Diagnosis command
     *
     * @return void
     */
    protected function runSelfDiagnosis()
    {
        $this->info('[START] Run self-diagnosis..........');

        $this->call('vendor:publish', [
            '--provider' => 'BeyondCode\\SelfDiagnosis\\SelfDiagnosisServiceProvider'
        ]);

        $this->call('self-diagnosis');

        $this->info('[DONE ] Run self-diagnosis.');
    }
}
