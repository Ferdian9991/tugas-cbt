<?php

namespace App\Models\Traits;

use App\Models\User;

trait ExtendedLog
{
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    protected static function bootExtendedLog()
    {
        static::creating(function ($model) {
            if ($model->usesTimestamps() && !empty($model->getCreatedAtColumn()) && !empty(request()->user)) {
                $model->created_by = request()->user->id;
            }
        });
        static::updating(function ($model) {
            if ($model->usesTimestamps() && !empty($model->getUpdatedAtColumn()) && !empty(request()->user)) {
                $model->updated_by = request()->user->id;
            }
        });

        if (method_exists(static::class, 'softDeleted') && !empty(request()->user)) {
            static::softDeleted(function ($model) {
                $model->deleted_by = request()->user->id;
                $model->saveQuietly();
            });
        }
    }
}
