<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use App\Models\Package;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    protected array $searchables = ['code', 'name'];
    protected array $filterables = ['name'];
    protected array $sortables = ['code'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $params = $this->getIndexParams(
            searchables: $this->searchables,
            filterables: $this->filterables,
            sortables: $this->sortables
        );

        $exams = ExamSchedule::filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('exam.index')->with('exams', $exams);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = Package::pluck('name', 'id')->toArray();
        return view('exam.form')->with('packages', $packages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ExamSchedule::create($request->all());

        return redirect()->route('exams.index')->with('success', 'Berhasil menambahkan data jadwal ujian.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $exam = ExamSchedule::findOrFail($id);
        $packages = Package::pluck('name', 'id')->toArray();
        return view('exam.form')->with('exam', $exam)->with('packages', $packages);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ExamSchedule::findOrFail($id)->update($request->all());

        return redirect()->route('exams.index')->with('success', 'Berhasil memperbarui data jadwal ujian.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ExamSchedule::findOrFail($id)->delete();

        return redirect()->route('exams.index')->with('success', 'Berhasil menghapus data jadwal ujian.');
    }
}
