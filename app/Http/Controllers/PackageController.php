<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
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

        $packages = Package::filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('package.index')->with('packages', $packages);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('package.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:25',
            'name' => 'required|string|max:255',
            'is_random_question' => 'required|boolean',
            'is_random_choice' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);

        Package::create($data);

        return redirect()->route('packages.index')->with('success', 'Berhasil menambahkan data paket soal.');
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
        $package = Package::findOrFail((int) $id);

        return view('package.form')->with('package', $package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $package = Package::findOrFail((int) $id);

        $data = $request->validate([
            'code' => 'required|string|max:25',
            'name' => 'required|string|max:255',
            'is_random_question' => 'required|boolean',
            'is_random_choice' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);

        $package->update($data);

        return redirect()->route('packages.index')->with('success', 'Berhasil memperbarui data paket soal.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::findOrFail((int) $id);
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Berhasil menghapus data paket soal.');
    }
}
