<?php

namespace App\Models;

use App\Models\Traits\ExtendedLog;
use App\Models\Traits\ModelScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
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
        'is_random_question',
        'is_random_choice',
        'is_active',
    ];
}
