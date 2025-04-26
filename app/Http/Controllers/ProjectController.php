<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Category;
use App\Models\Client;

class ProjectController extends Controller
{
    private $project;
    private $category;
    private $client;

    public function __construct(Project $project, Category $category, Client $client){
        $this->project = $project;
        $this->category = $category;
        $this->client = $client;
    }

    public function create(){
        $all_categories = $this->category->all();
        $all_clients = $this->client->all();

        return view('projects.project-create')
                ->with('all_categories', $all_categories)
                ->with('all_clients', $all_clients);
    }

    public function store(Request $request){
        // $request->validate([
        //     'category'    => 'required|array|between:1,3',
        //     'description' => 'required|min:1|max:1000',
        //     'image'       => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        // ]);

        $this->project->user_id     = Auth::user()->id;
        $this->project->title     = $request->title;
        $this->project->status     = $request->status;
        $this->project->description = $request->description;
        $this->project->received_date = $request->received_date;
        $this->project->temp_pay_date = $request->temp_pay_date;
        $this->project->temp_deadline = $request->temp_deadline;
        $this->project->deadline = $request->deadline;
        $this->project->cost_per_character = $request->cost_per_character;
        $this->project->deadline_character = $request->deadline_character;
        $this->project->temp_salary = $request->temp_salary;
        $this->project->client_id = $request->client_id;
        $this->project->category_id = $request->category_id;
        $this->project->save();

        return redirect()->route('home');
    }
}
