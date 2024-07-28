<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $params = $this->getIndexParams(
            searchables: ['name', 'email'],
            filterables: ['name'],
            sortables: ['name']
        );

        $admins = User::where('role', User::ROLE_ADMIN)
            ->filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('admin.index')->with('admins', $admins);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'is_active' => 'required|boolean',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admins.index')->with('success', 'Berhasil menambahkan data admin.');
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
        $admin = User::findOrFail($id);

        return view('admin.form')->with('admin', $admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'is_active' => 'required|boolean',
        ]);

        $admin = User::findOrFail($id);
        $admin->update($data);

        return redirect()->route('admins.index')->with('success', 'Berhasil mengubah data admin.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Berhasil menghapus data admin.');
    }
}
