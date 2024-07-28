<?php

namespace App\Models;

use App\Models\Traits\ModelScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'participant_id',
        'package_question_id',
        'answer',
    ];

    public function participant()
    {
        return $this->belongsTo(ExamParticipant::class);
    }

    public function packageQuestion()
    {
        return $this->belongsTo(PackageQuestion::class);
    }
}
