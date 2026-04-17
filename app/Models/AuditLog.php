<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'action',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeByModel($query,string $modelType)
    {
        return $query->where('model_type',$modelType);
    }

    public function scopeByAction($query,string $action)
    {
        return $query->where('action',$action);
    }

}
