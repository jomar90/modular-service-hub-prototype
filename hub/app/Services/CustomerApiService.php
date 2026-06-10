<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class CustomerApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.customer.url'), '/');
    }

    public function paginate(int $page = 1, ?string $search = null): LengthAwarePaginator
    {
        $response = Http::get("{$this->baseUrl}/api/customers", [
            'page'   => $page,
            'search' => $search,
        ]);

        $json = $response->json();

        if ($response->failed() || ! isset($json['data'])) {
            return new LengthAwarePaginator(collect([]), 0, 15, $page);
        }

        return new LengthAwarePaginator(
            items: collect($json['data']),
            total: $json['meta']['total'] ?? 0,
            perPage: $json['meta']['per_page'] ?? 15,
            currentPage: $json['meta']['current_page'] ?? $page,
            options: ['path' => request()->url(), 'query' => request()->except('page')],
        );
    }

    public function find(int $id): ?array
    {
        $response = Http::get("{$this->baseUrl}/api/customers/{$id}");

        if ($response->failed()) {
            return null;
        }

        return $response->json('data');
    }

    /**
     * Fetch a specific set of customers in a single HTTP call.
     * Returns an array keyed by customer ID for O(1) lookup in views.
     */
    public function findMany(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $response = Http::get("{$this->baseUrl}/api/customers", [
            'ids' => implode(',', $ids),
        ]);

        if ($response->failed()) {
            return [];
        }

        return collect($response->json('data'))->keyBy('id')->all();
    }
}
