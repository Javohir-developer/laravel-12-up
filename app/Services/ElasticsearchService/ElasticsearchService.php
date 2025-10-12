<?php

namespace App\Services\ElasticsearchService;
use Elastic\Elasticsearch\ClientBuilder;
class ElasticsearchService
{
     protected $client;

    public function __construct()
    {
        $hosts = config('elasticsearch.hosts');
        $this->client = ClientBuilder::create()
            ->setHosts($hosts)
            // ->setSSLVerification(false) // lokal uchun kerak
            ->build();
    }

    public function createIndex(string $indexName, array $mapping = []): array
    {
        try {
            // ✅ 9.x da exists() natijasini ->asBool() bilan olish kerak
            $exists = $this->client->indices()->exists(['index' => $indexName])->asBool();

            if ($exists) {
                return ['acknowledged' => true, 'message' => 'Index exists'];
            }

            // ✅ Yangi indeks yaratish
            $response = $this->client->indices()->create([
                'index' => $indexName,
                'body' => $mapping,
            ]);

            return $response->asArray();
        } catch (\Exception $e) {
            return ['acknowledged' => false, 'error' => $e->getMessage()];
        }
    }


    // hujjat indexlash
    public function indexDocument(string $index, array $body, ?string $id = null)
    {
        $params = [
            'index' => $index,
            'body' => $body,
            'refresh' => true,
        ];

        if ($id) {
            $params['id'] = $id;
        }

        return $this->client->index($params);
    }


    // hujjat o'chirish
    public function deleteDocument(string $index, string $id)
    {
        return $this->client->delete([
            'index' => $index,
            'id' => $id,
            'refresh' => true,
        ]);
    }

    // oddiy qidiruv
    public function search(string $index, array $query, int $size = 10, int $from = 0)
    {
        return $this->client->search([
            'index' => $index,
            'body' => [
                'from' => $from,
                'size' => $size,
                'query' => $query,
            ],
        ]);
    }

    // raw client olish (zarur bo'lsa)
    public function client()
    {
        return $this->client;
    }
}
