<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Category;
use App\Models\Client;
use App\Models\WorkType;
use App\Models\WorkSession;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    private $project;
    private $category;
    private $client;
    private $work_type;
    private $work_session;

    public function __construct(Project $project, Category $category, Client $client, WorkType $work_type, WorkSession $work_session){
        $this->project = $project;
        $this->category = $category;
        $this->client = $client;
        $this->work_type = $work_type;
        $this->work_session = $work_session;
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

    public function show($id, Request $request){
        $project = $this->project->findOrFail($id);
        $all_work_types = $this->work_type->all();
        $user_id = Auth::user()->id;

        // GETパラメータから選択されたwork_type_idを取得（なければ先頭のIDを使う）
        $selectedWorkTypeId = $request->query('work_type_id', $all_work_types->first()->id ?? null);

        // 指定されたwork_typeの作業時間（分）
        $workingMinutes = (int) (
            WorkSession::where('user_id', $user_id)
                ->where('project_id', $project->id)
                ->where('work_type_id', $selectedWorkTypeId)
                ->select(DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total'))
                ->value('total') ?? 0
        );

        // 総作業時間（分）
        $totalMinutes = (int) (
            WorkSession::where('user_id', $user_id)
                ->where('project_id', $project->id)
                ->select(DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total'))
                ->value('total') ?? 0
        );

        return view('projects.project-show', [
            'project' => $project,
            'all_work_types' => $all_work_types,
            'selectedWorkTypeId' => $selectedWorkTypeId,
            'workingMinutes' => $workingMinutes,
            'totalMinutes' => $totalMinutes,
        ]);
    }


    public function updateStatus(Request $request, $id){
        // $validated = $request->validate([
        //     'status' => 'required|string|max:50',
        // ]);

        $project = $this->project->findOrFail($id);

        $project->status = $request->status;
        $project->save();

        return redirect()->back();
    }

    public function updatePayDate(Request $request, $id){
        $project = $this->project->findOrFail($id);

        $project->pay_date = $request->pay_date;
        $project->save();

        return redirect()->back();
    }

    public function updateSalary(Request $request, $id){
        $project = $this->project->findOrFail($id);

        $project->salary = $request->salary;
        $project->save();

        return redirect()->back();
    }

    public function updateTotalCharacters(Request $request, $id){
        $project = $this->project->findOrFail($id);

        $project->total_characters = $request->total_characters;
        $project->save();

        return redirect()->back();
    }

    public function edit($id){
        $all_categories = $this->category->all();
        $all_clients = $this->client->all();

        $project = $this->project->findOrFail($id);

        return view('projects.project-edit')
                ->with('all_categories', $all_categories)
                ->with('all_clients', $all_clients)
                ->with('project', $project);
    }

    public function update(Request $request, $id){
        // $request->validate([
        //     'category'    => 'required|array|between:1,3',
        //     'description' => 'required|min:1|max:1000',
        //     'image'       => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        // ]);

        $project = $this->project->findOrFail($id);

        $project->user_id     = Auth::user()->id;
        $project->title     = $request->title;
        $project->status     = $request->status;
        $project->description = $request->description;
        $project->received_date = $request->received_date;
        $project->temp_pay_date = $request->temp_pay_date;
        $project->temp_deadline = $request->temp_deadline;
        $project->deadline = $request->deadline;
        $project->cost_per_character = $request->cost_per_character;
        $project->deadline_character = $request->deadline_character;
        $project->temp_salary = $request->temp_salary;
        $project->client_id = $request->client_id;
        $project->category_id = $request->category_id;
        $project->save();

        return redirect()->route('project.show', $id);
    }

    public function destroy($id){
        $this->project->destroy($id);

        return redirect()->route('home');
    }

    public function indexTable(){
        $all_work_types = $this->work_type->all();
        $all_projects = $this->project->orderBy('received_date', 'asc')->paginate(20);

        return view('projects.project-table')
                ->with('all_projects', $all_projects)
                ->with('all_work_types', $all_work_types);
    }
}
