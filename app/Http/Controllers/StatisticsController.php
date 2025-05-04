<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\WorkType;

class StatisticsController extends Controller
{
public function summary(Request $request)
{
    $userId = auth()->id();

    // start: 任意。指定がなければ「2000-01-01」
    $startDate = $request->input('start', '2000-01-01');

    // end: 任意。指定がなければ今日
    $endDate = $request->input('end', now()->toDateString());

    // 「完了」ステータスだけ対象
    $completedStatus = '完了';

    // 完了した案件の統計
    $projectData = DB::table('projects')
        ->where('user_id', $userId)
        ->where('status', $completedStatus)
        ->whereBetween('received_date', [$startDate, $endDate])
        ->selectRaw('COUNT(*) as project_count, SUM(total_characters) as total_characters, SUM(salary) as total_salary')
        ->first();

    // 全作業時間（work_sessions には status フィルタ不要）
    $workTimeData = DB::table('work_sessions')
        ->where('user_id', $userId)
        ->whereBetween('start_time', [$startDate, $endDate])
        ->selectRaw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total_minutes')
        ->first();

    // 値を初期化
    $characters = $projectData->total_characters ?? 0;
    $minutes = $workTimeData->total_minutes ?? 0;
    $salary = $projectData->total_salary ?? 0;

    // 1時間あたりの文字数と時給を計算
    $charactersPerHour = $minutes > 0 ? round($characters / ($minutes / 60), 2) : 0;
    $hourlyRate = $minutes > 0 ? round($salary / ($minutes / 60), 2) : 0;

    return response()->json([
        'project_count' => $projectData->project_count,
        'total_characters' => $characters,
        'total_salary' => $salary,
        'total_minutes' => $minutes,
        'characters_per_hour' => $charactersPerHour,
        'hourly_rate' => $hourlyRate,
    ]);
}

public function charts(Request $request)
{
    $userId = auth()->id();
    $startDate = $request->input('start', '2000-01-01');
    $endDate = $request->input('end', now()->toDateString());

    // 案件の仕事内容の割合
    $jobTypeDistribution = DB::table('projects')
        ->join('categories', 'projects.category_id', '=', 'categories.id')
        ->where('projects.user_id', $userId)
        ->whereBetween('projects.received_date', [$startDate, $endDate])
        ->select('categories.name as label', DB::raw('count(*) as count'))
        ->groupBy('categories.name')
        ->get();

    // 作業別時間割合
    $workTypeDistribution = DB::table('work_sessions')
        ->join('work_types', 'work_sessions.work_type_id', '=', 'work_types.id')
        ->where('work_sessions.user_id', $userId)
        ->whereBetween('start_time', [$startDate, $endDate])
        ->select('work_types.name as label', DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as minutes'))
        ->groupBy('work_types.name')
        ->get();

    // クライアント割合
    $clientDistribution = DB::table('projects')
        ->join('clients', 'projects.client_id', '=', 'clients.id')
        ->where('projects.user_id', $userId)
        ->whereBetween('projects.received_date', [$startDate, $endDate])
        ->select('clients.name as label', DB::raw('count(*) as count'))
        ->groupBy('clients.name')
        ->get();

    return response()->json([
        'job_types' => $jobTypeDistribution,
        'work_types' => $workTypeDistribution,
        'clients' => $clientDistribution,
    ]);
}

}
