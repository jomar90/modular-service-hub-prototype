<?php

namespace App\Http\Controllers;

use App\Services\CustomerApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerApiService $customers,
    ) {}

    public function index(Request $request): View
    {
        $customers = $this->customers->paginate(
            page: (int) $request->get('page', 1),
            search: $request->get('search'),
        );

        return view('customers.index', compact('customers'));
    }

    public function show(int $id): View
    {
        $customer = $this->customers->find($id);

        abort_if($customer === null, 404);

        return view('customers.show', compact('customer'));
    }
}
