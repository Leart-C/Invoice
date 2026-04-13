<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'invoice_number', 'status',
        'issue_date', 'due_date', 'subtotal',
        'tax', 'total', 'amount_paid', 'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date'   => 'date',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['search'])) {
            $query->where('invoice_number', 'like', "%{$filters['search']}%");
        }

        return $query;
    }

    // Business logic
    public static function generateNumber(): string
    {
        $last = self::latest('id')->first();
        $next = $last ? ((int) substr($last->invoice_number, -4)) + 1 : 1;
        return 'INV-' . date('Y') . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function canBeEdited(): bool
    {
        return $this->status === 'draft';
    }

    public function canBeDeleted(): bool
    {
        return $this->status === 'draft';
    }

    public function markAsSent(): void
    {
        $this->update(['status' => 'sent']);
    }

    public function getRemainingBalanceAttribute(): float
    {
        return $this->total - $this->amount_paid;
    }
}