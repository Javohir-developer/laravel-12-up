<?php

namespace App\Console\Commands;
use App\Services\ElasticsearchService\ElasticsearchService;
use Illuminate\Console\Command;

class CreateMoviesIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-movies-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    $this->info("🔧 Creating 'movies' index in Elasticsearch...");

    $es = app(ElasticsearchService::class);

    $mapping = [
        'mappings' => [
            'properties' => [
                'title' => ['type' => 'text', 'analyzer' => 'standard'],
                'body' => ['type' => 'text', 'analyzer' => 'standard'],
                'author_id' => ['type' => 'integer'],
                'published_at' => [
                    'type' => 'date',
                    'format' => 'strict_date_optional_time||epoch_millis'
                ],
            ],
        ],
    ];

    $response = $es->createIndex('movies', $mapping);

    $this->info(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $this->info("✅ Done.");
}

}
