<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class ElasticLogSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:log_setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Elasticsearch log index';

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
     * @return int
     */
    public function handle()
    {
        $client = ClientBuilder::create()->build(); 

        $index = rtrim(config('elastic_log.prefix'), '_') . '_' . config('elastic_log.index');

        if (!$client->indices()->exists(['index' => $index])) {
            $client->indices()->create([
                'index' => $index,
            ]);
        }

        $this->info('Elasticsearch log index setup complete.');
    }
}
