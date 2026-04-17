<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function($model){
            static::log('created',null,$model->getAuditableAttributes());
        });

        static::updated(function ($model){
            $old = array_intersect_key(
                $model->getOriginal(),
                $model->getAuditableAttributes()
            );
            $new = array_intersect_key(
                $model->getChanges(),
                $model->getAuditableAttributes()
            );

            if(!empty($new)){
                static::log('updated',$old,$new);
            }
        });

        static::deleted(function ($model){
            static::log('deleted',$model->getAuditableAttributes(),null);
        });
    }

    private static function log(string $action, ?array $old, ?array $new): void
    {
        $model = new static();

        AuditLog::create([
            'user_id' => Auth::id(),
            'model_type' => class_basename(static::class),
            'model_id' => $model->getKey() ?? 0,
            'action' => $action,
            'old_values' => $old,
            'new_values' => $new,
        ]);
    }

    private function getAuditableAttributes(): array
    {
        $excluded = $this->auditExclude ?? ['password','google_id','remember_token'];
        return array_diff_key(
            $this->getAttributes(),
            array_flip($excluded)
        );
    }
}