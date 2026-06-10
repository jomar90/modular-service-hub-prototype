@extends('layouts.app')

@section('title', $invoice['invoice_number'])

@section('content')

@php
    $statusColors = [
        'paid'    => 'bg-green-100 text-green-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'overdue' => 'bg-red-100 text-red-800',
    ];
@endphp

<div class="mb-6">
    <a href="{{ route('invoices.index') }}"
       class="text-sm text-brand hover:underline">← Back to Invoices</a>
</div>

<div class="bg-white rounded-xl border border-gray-200 max-w-lg">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ $invoice['invoice_number'] }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Invoice #{{ $invoice['id'] }}</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                     {{ $statusColors[$invoice['status']] ?? 'bg-gray-100 text-gray-700' }}">
            {{ ucfirst($invoice['status']) }}
        </span>
    </div>

    <dl class="divide-y divide-gray-100">
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Customer</dt>
            <dd class="text-gray-900">
                @if($customer)
                    <a href="{{ route('customers.show', $customer['id']) }}"
                       class="text-brand hover:underline">{{ $customer['name'] }}</a>
                @else
                    <span class="text-gray-400">Unknown (ID: {{ $invoice['customer_id'] }})</span>
                @endif
            </dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Amount</dt>
            <dd class="text-gray-900 font-semibold">€ {{ number_format($invoice['amount'], 2) }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Due date</dt>
            <dd class="text-gray-900">{{ $invoice['due_date'] }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Created</dt>
            <dd class="text-gray-400">{{ $invoice['created_at'] }}</dd>
        </div>
    </dl>
</div>

@endsection
