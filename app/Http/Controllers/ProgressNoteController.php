<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressNote;

class ProgressNoteController extends Controller
{
    private $progressNote;

    public function __construct(ProgressNote $progressNote){
        $this->progressNote = $progressNote;
    }

    public function index($id){
        $all_notes = $this->progressNote
                      ->where('project_id', $id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(6);
        $project_id = $id;

        return view('projects.project-notes', compact('all_notes', 'project_id'));
    }

    public function store(Request $request, $id){
        // $request->validate([
        //     'name'    => 'required|min:1|max:50|unique:clients,name',
        //     'description'        => 'nullable|string|min:1|max:1000'
        // ]);

        $this->progressNote->project_id = $id;
        $this->progressNote->note = $request->note;
        $this->progressNote->save();

        return redirect()->back();
    }

    public function update(Request $request, $id){
        // $request->validate([
        //     'name'    => 'required|min:1|max:50|unique:clients,name',
        //     'description'        => 'nullable|string|min:1|max:1000'
        // ]);

        $note = $this->progressNote->findOrFail($id);
        $note->note = $request->note;
        $note->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->progressNote->destroy($id);

        return redirect()->back();
    }
}
