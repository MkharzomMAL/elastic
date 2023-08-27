<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\ElasticsearchFormatter;
use Monolog\Handler\ElasticsearchHandler;

class ElasticLogProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $index = rtrim(config('elastic_log.prefix'), '_') . '_' . config('elastic_log.index');
        $type = config('elastic_log.type');

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts([config('elastic_log.host')])
                ->setBasicAuthentication(env('ELASTICSEARCH_USER'), env('ELASTICSEARCH_PASSWORD'))
                // ->setCABundle('path/to/http_ca.crt')
                ->build();
        });

        $this->app->bind(ElasticsearchFormatter::class, function ($app) use ($index, $type) {
            return new ElasticsearchFormatter($index, $type);
        });

        $this->app->bind(ElasticsearchHandler::class, function ($app) use ($index, $type) {
            return new ElasticsearchHandler($app->make(Client::class), [
                'index'        => $index,
                'type'         => $type,
                'ignore_error' => false,
            ]);
        });
    }
}
