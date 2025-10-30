<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    public function create()
    {
        return view('page-branch.create-position');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric',
        ]);

        Position::create($validated);
        return redirect()->back();
    }

    public function show(Position $position)
    {
        return view('', compact('position'));
    }

    public function edit(Position $position)
    {
        return view('', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric',
        ]);

        $position->update($validated);
        return redirect()->back();
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->back();
    }
}
