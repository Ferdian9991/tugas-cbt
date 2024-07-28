<?php

namespace App\Models;

use App\Models\Traits\ExtendedLog;
use App\Models\Traits\ModelScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamParticipant extends Model
{
    use HasFactory, SoftDeletes, ModelScope, ExtendedLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_schedules_id',
        'user_id',
        'is_started',
        'is_finished',
        'score',
        'started_at',
        'finished_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedules_id');
    }
}
