<?php

namespace App\Http\Controllers;

use App\Models\ExamParticipant;
use App\Models\ExamSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class ExamParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $examId)
    {
        $exam = ExamSchedule::findOrFail((int) $examId);

        $params = $this->getIndexParams(
            searchables: ['name', 'email'],
            filterables: ['name'],
            sortables: ['name']
        );

        $participants = ExamParticipant::with('user')
            ->where('exam_schedules_id', $exam->id)
            ->filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('exam_participant.index')->with('participants', $participants)
            ->with('exam', $exam);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $examId)
    {
        $availableParticipants = User::where('role', User::ROLE_USER)
            ->whereDoesntHave('examParticipants', function ($query) use ($examId) {
                $query->where('exam_schedules_id', $examId);
            })
            ->get();

        return view('exam_participant.form')
            ->with('availableParticipants', $availableParticipants)
            ->with('examId', $examId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $examId)
    {
        $request->validate([
            'user_id' => 'required|numeric',
        ]);

        ExamParticipant::create([
            'exam_schedules_id' => $examId,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('exam_participants.index', $examId)
            ->with('success', 'Peserta berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $examId, string $userId)
    {
        $participant = ExamParticipant::where('exam_schedules_id', $examId)
            ->where('user_id', $userId);

        if (!$participant->exists()) {
            return redirect()->route('exam_participants.index', $examId)
                ->with('error', 'Peserta tidak ditemukan');
        }

        $participant->delete();

        return redirect()->route('exam_participants.index', $examId)
            ->with('success', 'Peserta berhasil dihapus');
    }
}
