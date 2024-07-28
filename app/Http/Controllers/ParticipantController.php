<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ParticipantController extends Controller
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

        $participants = User::where('role', User::ROLE_USER)
            ->filterPage($params['filter'])
            ->sortPage($params['sort'])
            ->paginate($params['limit'], ['*'], 'page', $params['page']);

        return view('participant.index')->with('participants', $participants);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('participant.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'participant_number' => 'string|max:25',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'is_active' => 'required|boolean',
        ]);

        $data['password'] = bcrypt($data['participant_number']);
        $data['role'] = User::ROLE_USER;
        if (empty($data['participant_number'])) {
            $data['participant_number'] = Str::password(10, true, true, false, false);
        }

        User::create($data);

        return redirect()->route('participants.index')->with('success', 'Berhasil menambahkan data peserta.');
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
        $participant = User::findOrFail((int)$id);

        return view('participant.form')->with('participant', $participant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $participant = User::findOrFail((int)$id);

        $data = $request->validate([
            'participant_number' => 'string|max:25',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $participant->id,
            'phone' => 'required|string|max:15',
            'is_active' => 'required|boolean',
        ]);

        $participant->update($data);

        return redirect()->route('participants.index')->with('success', 'Berhasil memperbarui data peserta.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = User::findOrFail((int)$id);
        $participant->delete();

        return redirect()->route('participants.index')->with('success', 'Berhasil menghapus data peserta.');
    }
}
