<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkType;

class WorkTypeController extends Controller
{
    private $work_type;

    public function __construct(WorkType $work_type){
        $this->work_type = $work_type;
    }

    public function create(){
        $all_wrok_types = $this->work_type->paginate(10);

        return view('projects.work_type-create')
                ->with('all_work_types', $all_wrok_types);
    }

    public function store(Request $request){
        $request->validate([
            'work_type'    => 'required|min:1|max:50|unique:categories,name'
        ]);

        $this->work_type->name = $request->work_type;
        $this->work_type->save();

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'work_type'    => 'required|min:1|max:50|unique:categories,name'
        ]);

        $work_type = $this->work_type->findOrFail($id);
        $work_type->name = $request->work_type;
        $work_type->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->work_type->destroy($id);

        return redirect()->back();
    }
}
