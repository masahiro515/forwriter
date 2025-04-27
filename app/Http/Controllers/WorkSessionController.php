<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSession;
use Carbon\Carbon;

class WorkSessionController extends Controller
{
    private $work_session;

    public function __construct(WorkSession $work_session){
        $this->work_session = $work_session;
    }

    public function store(Request $request){
        $request->validate([
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'work_type_id' => ['required', 'exists:work_types,id'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $this->work_session->user_id     = Auth::user()->id;
        $this->work_session->start_time = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $this->work_session->end_time = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
        $this->work_session->work_type_id     = $request->work_type_id;
        $this->work_session->project_id     = $request->project_id;

        $this->work_session->save();

        return redirect()->back();
    }

}
