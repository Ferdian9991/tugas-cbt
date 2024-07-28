<?php

namespace App\Models;

use App\Models\Traits\ExtendedLog;
use App\Models\Traits\ModelScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageQuestion extends Model
{
    use HasFactory, SoftDeletes, ModelScope, ExtendedLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'package_id',
        'number',
        'header',
        'text',
        'choices',
        'correct_choice',
    ];

    /**
     * Get the package that owns the question.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
