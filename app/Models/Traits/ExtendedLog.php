<?php

namespace App\Models\Traits;

use App\Models\User;

trait ExtendedLog
{
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    protected static function bootExtendedLog()
    {
        static::creating(function ($model) {
            if ($model->usesTimestamps() && !empty($model->getCreatedAtColumn()) && !empty(auth()->user())) {
                $model->created_by = auth()->user()->id;
            }
        });
        static::updating(function ($model) {
            if ($model->usesTimestamps() && !empty($model->getUpdatedAtColumn()) && !empty(auth()->user())) {
                $model->updated_by = auth()->user()->id;
            }
        });

        if (method_exists(static::class, 'softDeleted') && !empty(auth()->user())) {
            static::softDeleted(function ($model) {
                $model->deleted_by = auth()->user()->id;
                $model->saveQuietly();
            });
        }
    }
}
