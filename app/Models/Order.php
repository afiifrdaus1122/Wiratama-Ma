<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'quotation_number',
        'quotation_valid_until',
        'quotation_file',
        'quotation_notes',
        'contact_person',
        'email',
        'phone',
        'company_name',
        'address',
        'city',
        'notes',
        'subtotal',
        'tax',
        'total_amount',
        'status',
        'snap_token',
        'payment_status',
        'payment_type',
    ];

    protected $casts = [
        'quotation_valid_until' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }
}
