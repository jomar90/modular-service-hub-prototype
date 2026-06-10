<?php

namespace App\Http\Controllers;

use App\Services\CustomerApiService;
use App\Services\InvoiceApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceApiService $invoices,
        private readonly CustomerApiService $customers,
    ) {}

    public function index(Request $request): View
    {
        $invoices = $this->invoices->paginate(
            page: (int) $request->get('page', 1),
            status: $request->get('status'),
        );

        // Collect unique customer IDs from this page, then fetch them all in one HTTP call.
        $customerIds = $invoices->pluck('customer_id')->unique()->filter()->values()->all();
        $customers   = $this->customers->findMany($customerIds);

        return view('invoices.index', compact('invoices', 'customers'));
    }

    public function show(int $id): View
    {
        $invoice  = $this->invoices->find($id);

        abort_if($invoice === null, 404);

        $customer = $this->customers->find($invoice['customer_id']);

        return view('invoices.show', compact('invoice', 'customer'));
    }
}
