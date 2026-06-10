@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-3xl">
    <p class="text-gray-500 mb-8">
        Welcome to the Service Hub. Select a service from the sidebar to get started.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        <a href="{{ route('customers.index') }}"
           class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md hover:border-brand-muted transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 group-hover:text-brand transition">Customer Viewer</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Browse and search customers</p>
                </div>
            </div>
        </a>

        <a href="{{ route('invoices.index') }}"
           class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md hover:border-brand-muted transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 group-hover:text-brand transition">Invoice Viewer</h2>
                    <p class="text-sm text-gray-500 mt-0.5">View and filter invoices</p>
                </div>
            </div>
        </a>

    </div>
</div>
@endsection
