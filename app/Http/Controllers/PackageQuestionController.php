<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageQuestion;
use Illuminate\Http\Request;

class PackageQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $packageId)
    {
        $package = Package::findOrFail((int) $packageId);

        $params = $this->getIndexParams(
            searchables: ['header', 'text'],
            filterables: ['header'],
            sortables: ['number']
        );

        $questions = PackageQuestion::where('package_id', (int) $packageId)
            ->filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('package_question.index')->with('questions', $questions)
            ->with('package', $package);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $packageId)
    {
        return view('package_question.form')->with('packageId', $packageId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $packageId)
    {
        $data = $request->validate([
            'header' => 'nullable|string',
            'question' => 'required|string',
            'number' => 'required|integer|unique:package_questions,number,NULL,id,package_id,' . $packageId,
            'correct_choice' => 'required|string|in:A,B,C,D,E',
        ]);

        $choices = $request->only([
            'option_a', 'option_b', 'option_c', 'option_d', 'option_e'
        ]);

        $choices = array_filter($choices, fn ($choice) => $choice !== null);
        $choices = array_map(fn ($choice, $key) => [
            'number' => strtoupper(str_replace('option_', '', $key)),
            'text' => $choice
        ], $choices, array_keys($choices));

        $data['package_id'] = $packageId;
        $data['text'] = $data['question'];
        $data['choices'] = json_encode($choices);

        PackageQuestion::create($data);

        return redirect()->route('questions.index', [$packageId])
            ->with('success', 'Berhasil menambahkan pertanyaan.');
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
    public function edit(string $packageId, string $id)
    {
        $question = PackageQuestion::findOrFail((int) $id);
        $question->question = $question->text;

        return view('package_question.form')
            ->with('packageId', $packageId)
            ->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $packageId, string $id)
    {
        $data = $request->validate([
            'header' => 'nullable|string',
            'question' => 'required|string',
            'number' => 'required|integer|unique:package_questions,number,' . $id . ',id,package_id,' . $packageId,
            'correct_choice' => 'required|string|in:A,B,C,D,E',
        ]);

        $choices = $request->only([
            'option_a', 'option_b', 'option_c', 'option_d', 'option_e'
        ]);

        $choices = array_filter($choices, fn ($choice) => $choice !== null);
        $choices = array_map(fn ($choice, $key) => [
            'number' => strtoupper(str_replace('option_', '', $key)),
            'text' => $choice
        ], $choices, array_keys($choices));

        $data['package_id'] = $packageId;
        $data['text'] = $data['question'];
        $data['choices'] = json_encode($choices);

        PackageQuestion::findOrFail((int) $id)->update($data);

        return redirect()->route('questions.index', [$packageId])
            ->with('success', 'Berhasil mengubah pertanyaan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PackageQuestion::findOrFail((int) $id)->delete();

        return redirect()->back()
            ->with('success', 'Berhasil menghapus pertanyaan.');
    }
}
