<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{

    private $project;

    public function __construct(Project $project){
        $this->project = $project;
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
        $all_projects = $this->project->all();
        $order_deadline_projects = $this->project->orderBy('deadline', 'asc')->get();
        $pickup_projects = Project::whereHas('pickup')->get();

        return view('home')
                ->with('all_projects', $all_projects)
                ->with('order_deadline_projects', $order_deadline_projects)
                ->with('pickup_projects', $pickup_projects);
    }
}
