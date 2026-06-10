@extends('layouts.app')

@section('title', $customer['name'])

@section('content')

<div class="mb-6">
    <a href="{{ route('customers.index') }}"
       class="text-sm text-brand hover:underline">← Back to Customers</a>
</div>

<div class="bg-white rounded-xl border border-gray-200 max-w-lg">
    <div class="px-6 py-5 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900">{{ $customer['name'] }}</h2>
        <p class="text-sm text-gray-400 mt-0.5">Customer #{{ $customer['id'] }}</p>
    </div>

    <dl class="divide-y divide-gray-100">
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Email</dt>
            <dd class="text-gray-900">{{ $customer['email'] }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Phone</dt>
            <dd class="text-gray-900">{{ $customer['phone'] ?? '—' }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-500 font-medium">Customer since</dt>
            <dd class="text-gray-900">{{ $customer['created_at'] }}</dd>
        </div>
    </dl>
</div>

@endsection
