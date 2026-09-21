<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'amount', 'currency', 'phone', 'paid_by', 'paid_at'];

    protected $casts = ['paid_at' => 'datetime'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}