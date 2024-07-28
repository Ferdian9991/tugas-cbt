<?php

namespace App\Http\Controllers;

use App\Models\ExamParticipant;
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
        //
    }
}
