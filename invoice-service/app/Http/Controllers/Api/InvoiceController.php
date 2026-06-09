<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'status' => ['nullable', Rule::in(['pending', 'paid', 'overdue'])],
        ]);

        $query = Invoice::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return InvoiceResource::collection(
            $query->orderBy('due_date', 'desc')->paginate(15)->withQueryString()
        );
    }

    public function show(Invoice $invoice): InvoiceResource
    {
        return new InvoiceResource($invoice);
    }
}
