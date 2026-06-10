@extends('layouts.app')

@section('title', 'Customers')

@section('content')

{{-- Search --}}
<form method="GET" action="{{ route('customers.index') }}" class="mb-6 flex gap-3 max-w-md">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search by name or email…"
        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-muted"
    >
    <button type="submit"
            class="px-4 py-2 bg-brand text-white text-sm rounded-lg hover:bg-brand-light transition">
        Search
    </button>
    @if(request('search'))
        <a href="{{ route('customers.index') }}"
           class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition">
            Clear
        </a>
    @endif
</form>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Since</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $customer['name'] }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $customer['email'] }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $customer['phone'] ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $customer['created_at'] }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('customers.show', $customer['id']) }}"
                       class="text-brand hover:underline text-xs font-medium">View →</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-400">No customers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($customers->hasPages())
<div class="mt-6">
    {{ $customers->links() }}
</div>
@endif

@endsection
