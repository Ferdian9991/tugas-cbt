<?php

namespace App\Http\Controllers;

use App\Models\ExamParticipant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamFrontController extends Controller
{
    protected array $searchables = ['code', 'name'];
    protected array $filterables = ['name'];
    protected array $sortables = ['code'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = auth()->user();

        $params = $this->getIndexParams(
            searchables: $this->searchables,
            filterables: $this->filterables,
            sortables: $this->sortables
        );

        $exams = ExamParticipant::where('user_id', $auth->id)
            ->with('examSchedule')
            ->filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('exam-front.index')
            ->with('exams', $exams);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = ExamParticipant::where('user_id', auth()->user()->id)
            ->where('exam_schedules_id', $id)
            ->first();

        if (!$exam) {
            abort(404);
        }

        if ($exam->is_finished) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian sudah selesai');
        }

        if (!$exam->is_started) {
            return redirect()->route('exam-front.index')->with('error', 'Akses ditolak');
        }

        $examInfo = $exam->examSchedule;
        $examDuration = $examInfo->duration;
        $examStartedAt = Carbon::parse($exam->started_at);

        $examEndAt = $examStartedAt->copy()->addMinutes($examDuration);

        $currentTime = Carbon::now();

        if ($currentTime->greaterThan($examEndAt)) {
            $availableTime = 0;
        } else {
            $availableTime = $currentTime->diffInMinutes($examEndAt);
        }

        $questions = $examInfo->package->questions;

        return view('exam-front.show')
            ->with('exam', $exam)
            ->with('examInfo', $examInfo)
            ->with('availableTime', $availableTime)
            ->with('questions', $questions);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $exam = ExamParticipant::where('user_id', auth()->user()->id)
            ->where('exam_schedules_id', $id)
            ->first();

        $exam->update([
            'started_at' => now(),
            'is_started' => true,
        ]);

        return redirect()->route('exam-front.show', $id);
    }
}
