<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\WorkType;
use Carbon\Carbon;

class HomeController extends Controller
{

    private $project;
    private $work_type;

    public function __construct(Project $project, WorkType $work_type){
        $this->project = $project;
        $this->work_type = $work_type;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $all_projects = Project::whereBetween('received_date', [$startOfMonth, $endOfMonth])->get();
        $all_work_types = $this->work_type->all();
        $order_deadline_projects = $this->project
            ->whereIn('status', ['受注', '作業中', '確認中'])
            ->orderBy('deadline', 'asc')
            ->get();
        $pickup_projects = Project::whereHas('pickup')->get();

        return view('home')
                ->with('all_projects', $all_projects)
                ->with('order_deadline_projects', $order_deadline_projects)
                ->with('pickup_projects', $pickup_projects)
                ->with('all_work_types', $all_work_types)
                ->with('startOfMonth', $startOfMonth);
    }
}
