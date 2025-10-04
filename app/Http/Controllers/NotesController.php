<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    //
    public function index()
    {
        $notes = Note::latest()->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'note_name' => 'required|string|max:255',
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('notes', 'public');

        Note::create([
            'name' => $request->note_name,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }
    public function download($id)
    {
        $note = Note::findOrFail($id);
        $path = storage_path('app/public/' . $note->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $downloadName = 'OOP ' . $note->name . '.' . $extension;
        return response()->download($path, $downloadName);
    }

}
