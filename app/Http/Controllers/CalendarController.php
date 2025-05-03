<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class CalendarController extends Controller
{
    private $project;

    public function __construct(Project $project){
        $this->project = $project;
    }

    public function index(){
        // イベントデータを取得（適宜変更）
        $projects = $this->project->whereNotNull('deadline')->get();

        // FullCalendarが期待する形式に変換して返す
        $formattedProjects = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'start' => $project->deadline,
                'synced' => $project->synced_to_google_at && $project->updated_at->lte($project->synced_to_google_at),
            ];
        });

        return response()->json($formattedProjects);
    }
}
