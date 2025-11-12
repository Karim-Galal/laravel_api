<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    protected $fillable = [
      'customer_id',
      'amount',
      'status',
      'billed_at',
      'paid_at',
    ];

    public function custommers () {
      return $this->belongsTo(  User::class);
    }
}
