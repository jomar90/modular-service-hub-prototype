<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'amount',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount'   => 'decimal:2',
    ];
}
