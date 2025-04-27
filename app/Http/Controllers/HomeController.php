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
        return view('home')
                ->with('all_project', $all_projects);
    }
}
