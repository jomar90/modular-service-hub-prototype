<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class InvoiceApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.invoice.url'), '/');
    }

    public function paginate(int $page = 1, ?string $status = null): LengthAwarePaginator
    {
        $response = Http::get("{$this->baseUrl}/api/invoices", [
            'page' => $page,
            'status' => $status,
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
        $response = Http::get("{$this->baseUrl}/api/invoices/{$id}");

        if ($response->failed()) {
            return null;
        }

        return $response->json('data');
    }
}
