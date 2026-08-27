<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
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

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
