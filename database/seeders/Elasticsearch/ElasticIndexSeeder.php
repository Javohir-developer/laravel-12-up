<?php

namespace Database\Seeders\Elasticsearch;
use App\Services\ElasticsearchService\ElasticsearchService;
use Illuminate\Database\Seeder;

class ElasticIndexSeeder extends Seeder
{
public function run(): void
    {
        $es = app(ElasticsearchService::class);
        // 3️⃣ — Test ma’lumotlari
        $testMovies = [
            [
                'title' => 'Inception',
                'body' => 'A skilled thief is offered a chance to have his past crimes forgiven if he can implant an idea into a person\'s subconscious.',
                'author_id' => 1,
                'published_at' => now()->toIso8601String(),
            ],
            [
                'title' => 'The Matrix',
                'body' => 'A computer hacker learns about the true nature of his reality and his role in the war against its controllers.',
                'author_id' => 2,
                'published_at' => now()->subDays(1)->toIso8601String(),
            ],
            [
                'title' => 'Interstellar',
                'body' => 'A team of explorers travels through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'author_id' => 3,
                'published_at' => now()->subDays(2)->toIso8601String(),
            ],
            [
                'title' => 'The Dark Knight',
                'body' => 'Batman faces the Joker, a criminal mastermind who plunges Gotham City into anarchy.',
                'author_id' => 4,
                'published_at' => now()->subDays(3)->toIso8601String(),
            ],
        ];

        // 4️⃣ — Har birini Elasticsearch'ga qo‘shish
        foreach ($testMovies as $movie) {
            $es->indexDocument('movies', $movie);
        }

        $this->command->info("🎬 Test movies indexed successfully in Elasticsearch!");
    }
}
