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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
