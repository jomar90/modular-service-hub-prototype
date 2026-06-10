@extends('layouts.app')

@section('title', 'Invoices')

@section('content')

@php
    $statusColors = [
        'paid'    => 'bg-green-100 text-green-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'overdue' => 'bg-red-100 text-red-800',
    ];
@endphp

{{-- Status filter --}}
<div class="mb-6 flex gap-2 flex-wrap">
    <a href="{{ route('invoices.index') }}"
       class="px-4 py-1.5 rounded-full text-sm transition border
              {{ !request('status') ? 'bg-brand text-white border-brand' : 'bg-white text-gray-600 border-gray-300 hover:border-brand-muted' }}">
        All
    </a>
    @foreach(['pending', 'paid', 'overdue'] as $s)
    <a href="{{ route('invoices.index', ['status' => $s]) }}"
       class="px-4 py-1.5 rounded-full text-sm transition border capitalize
              {{ request('status') === $s ? 'bg-brand text-white border-brand' : 'bg-white text-gray-600 border-gray-300 hover:border-brand-muted' }}">
        {{ ucfirst($s) }}
    </a>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Due Date</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($invoices as $invoice)
            @php $customer = $customers[$invoice['customer_id']] ?? null; @endphp
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $invoice['invoice_number'] }}</td>
                <td class="px-6 py-4 text-gray-600">
                    @if($customer)
                        <a href="{{ route('customers.show', $customer['id']) }}"
                           class="hover:text-brand hover:underline">{{ $customer['name'] }}</a>
                    @else
                        <span class="text-gray-400">Unknown</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-900 font-medium">
                    € {{ number_format($invoice['amount'], 2) }}
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                 {{ $statusColors[$invoice['status']] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($invoice['status']) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $invoice['due_date'] }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('invoices.show', $invoice['id']) }}"
                       class="text-brand hover:underline text-xs font-medium">View →</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-400">No invoices found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($invoices->hasPages())
<div class="mt-6">
    {{ $invoices->links() }}
</div>
@endif

@endsection
