<?php

namespace App\Models;

use App\Models\Traits\ExtendedLog;
use App\Models\Traits\ModelScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSchedule extends Model
{
    use HasFactory, SoftDeletes, ModelScope, ExtendedLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'start_date',
        'end_date',
        'duration',
        'quota',
        'package_id',
        'is_active',
    ];
}
