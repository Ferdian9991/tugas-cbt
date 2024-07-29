<?php

namespace App\Http\Controllers;

use App\Models\ExamParticipant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $examInfo = $exam->examSchedule;

        if (!$examInfo->is_active) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak aktif');
        }

        if ($examInfo->start_date > now()) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian belum dimulai');
        }

        if ($examInfo->end_date < now()) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian sudah selesai');
        }

        if ($exam->is_finished) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian sudah selesai');
        }

        if (!$exam->is_started) {
            return redirect()->route('exam-front.index')->with('error', 'Akses ditolak');
        }

        $examDuration = $examInfo->duration;
        $examStartedAt = Carbon::parse($exam->started_at);

        $examEndAt = $examStartedAt->copy()->addMinutes($examDuration);

        $currentTime = Carbon::now();

        if ($currentTime->greaterThan($examEndAt)) {
            $availableTime = 0;
        } else {
            $availableTime = $currentTime->diffInMinutes($examEndAt);
        }

        $package = $examInfo->package;
        $questions = $package->questions;
        $answers = $exam->answers->pluck('answer', 'package_question_id');

        return view('exam-front.show')
            ->with('exam', $exam)
            ->with('examInfo', $examInfo)
            ->with('availableTime', $availableTime)
            ->with('questions', $questions)
            ->with('answers', $answers)
            ->with('package', $package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $exam = ExamParticipant::where('user_id', auth()->user()->id)
            ->where('exam_schedules_id', $id)
            ->first();

        if (!$exam) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak ditemukan');
        }

        $examInfo = $exam->examSchedule;

        if (!$examInfo->is_active) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak aktif');
        }

        if ($exam->is_finished) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian sudah selesai');
        }

        if (!$exam->is_started) {
            $exam->update([
                'started_at' => now(),
                'is_started' => true,
            ]);
        }

        return redirect()->route('exam-front.show', $id);
    }

    public function updateParticipantAnswer(Request $request, string $id)
    {
        $exam = ExamParticipant::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

        if (!$exam) {
            return response()->json([
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        if ($exam->is_finished) {
            return response()->json([
                'message' => 'Ujian sudah selesai'
            ], 403);
        }

        $examInfo = $exam->examSchedule;

        if (!$examInfo->is_active) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak aktif');
        }

        $examDuration = $examInfo->duration;
        $examStartedAt = Carbon::parse($exam->started_at);

        $examEndAt = $examStartedAt->copy()->addMinutes($examDuration);

        $currentTime = Carbon::now();

        if ($currentTime->greaterThan($examEndAt)) {
            $availableTime = 0;
        } else {
            $availableTime = $currentTime->diffInMinutes($examEndAt);
        }

        if ($availableTime <= 0) {
            return response()->json([
                'message' => 'Waktu ujian sudah habis'
            ], 403);
        }

        try {
            $data = $request->validate([
                'question_id' => 'required|exists:package_questions,id',
                'answer' => 'required|in:A,B,C,D,E',
            ]);

            $exam->answers()->updateOrCreate(
                ['package_question_id' => $data['question_id'], 'participant_id' => $exam->id],
                ['answer' => $data['answer']]
            );
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal menyimpan jawaban'
            ], 422);
        }

        return response()->json([
            'message' => 'Berhasil menyimpan jawaban'
        ]);
    }

    public function submitExam(Request $request, string $id)
    {
        $exam = ExamParticipant::where('user_id', auth()->user()->id)
            ->where('exam_schedules_id', $id)
            ->first();

        if (!$exam) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak ditemukan');
        }

        $examInfo = $exam->examSchedule;
        if (!$examInfo->is_active) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak aktif');
        }

        if ($exam->is_finished) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian sudah selesai');
        }

        DB::beginTransaction();

        $correctAnswer = 0;
        $totalQuestion = $exam->examSchedule->package->questions->count();
        foreach ($exam->answers as $item) {
            $question = $item->packageQuestion;
            $correctChoice = $question->correct_choice;

            if ($item->answer === $correctChoice) {
                $correctAnswer++;
            }
        }

        $score = ($correctAnswer / $totalQuestion) * 100;

        $exam->update([
            'is_finished' => true,
            'finished_at' => now(),
            'score' => $score,
        ]);

        DB::commit();

        return redirect()->route('exam-front.thanks', [$id]);
    }

    public function thanks(string $id)
    {
        $exam = ExamParticipant::where('user_id', auth()->user()->id)
            ->where('exam_schedules_id', $id)
            ->first();

        if (!$exam) {
            abort(404);
        }

        $examInfo = $exam->examSchedule;
        if (!$examInfo->is_active) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian tidak aktif');
        }

        if (!$exam->is_finished) {
            return redirect()->route('exam-front.index')->with('error', 'Ujian belum selesai');
        }

        return view('exam-front.thanks');
    }
}
