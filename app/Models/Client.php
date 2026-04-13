<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company_name',
        'created_by'
    ];

    use SoftDeletes;

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term){
            $q->where('name','like',"%{$term}")
                ->orWhere('email','like',"%{$term}")
                ->orWhere('company_name','like',"%{$term}");
        });
    }

    public function getOutstandingBalanceAttribute():float
    {
        return $this->invoices()
            ->whereIn('status',['sent','partial','overdue'])
            ->sum(DB::raw('total - amount_paid'));
    }

    public function hasActiveInvoices(): bool
    {
        return $this->invoices()
            ->whereIn('status',['sent','partial','overdue'])
            ->exists();
    }

}
