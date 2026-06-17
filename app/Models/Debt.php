<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\DebtPayment;

class Debt extends Model {
    protected $fillable = ['customer_id', 'total_amount', 'remaining_amount', 'status', 'debt_date', 'due_date', 'notes'];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function payments() { return $this->hasMany(DebtPayment::class); }
}