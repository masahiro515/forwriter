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
        $projects = $this->project->all();

        // FullCalendarが期待する形式に変換して返す
        $formattedProjects = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'deadline' => $project->deadline>toIso8601String(), // 開始日時をISO 8601形式に変換
            ];
        });

        return response()->json($formattedProjects);
    }
}
