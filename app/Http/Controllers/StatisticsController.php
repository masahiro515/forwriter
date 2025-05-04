<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\WorkType;

class StatisticsController extends Controller
{
    public function monthlyAndWeeklyStats(Request $request)
{
    $userId = Auth::user()->id;

    // work_type一覧を事前に取得してマッピング
    $workTypes = WorkType::pluck('name', 'id');

    // 月別：文字数
    $monthlyCharacters = DB::table('projects')
        ->selectRaw('DATE_FORMAT(received_date, "%Y-%m") as period')
        ->selectRaw('SUM(total_characters) as total_characters')
        ->where('user_id', $userId)
        ->groupBy('period')
        ->orderBy('period', 'asc')
        ->get();

    // 月別：作業時間（分）
    $monthlyWorkTime = DB::table('work_sessions')
        ->selectRaw('DATE_FORMAT(start_time, "%Y-%m") as period')
        ->selectRaw('work_type_id, SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total_minutes')
        ->where('user_id', $userId)
        ->groupBy('period', 'work_type_id')
        ->orderBy('period', 'asc')
        ->get()
        ->map(function ($item) use ($workTypes) {
            return [
                'period' => $item->period,
                'work_type' => $workTypes[$item->work_type_id] ?? '不明',
                'total_minutes' => (int)$item->total_minutes,
            ];
        });

    // 週別：文字数
    $weeklyCharacters = DB::table('projects')
        ->selectRaw('YEAR(received_date) as year, WEEK(received_date, 3) as week')
        ->selectRaw('MIN(received_date) as week_start_date')
        ->selectRaw('SUM(total_characters) as total_characters')
        ->where('user_id', $userId)
        ->groupBy('year', 'week')
        ->orderBy('year', 'asc')
        ->orderBy('week', 'asc')
        ->get()
        ->map(function ($item) {
            $startDate = Carbon::parse($item->week_start_date)->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
            return [
                'year' => $item->year,
                'week' => $item->week,
                'week_range' => $startDate->format('Y/m/d') . '〜' . $endDate->format('Y/m/d'),
                'total_characters' => (int)$item->total_characters,
            ];
        });

    // 週別：作業時間
    $weeklyWorkTime = DB::table('work_sessions')
        ->selectRaw('YEAR(start_time) as year, WEEK(start_time, 3) as week')
        ->selectRaw('MIN(start_time) as week_start_date')
        ->selectRaw('work_type_id, SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total_minutes')
        ->where('user_id', $userId)
        ->groupBy('year', 'week', 'work_type_id')
        ->orderBy('year', 'asc')
        ->orderBy('week', 'asc')
        ->get()
        ->map(function ($item) use ($workTypes) {
            $startDate = Carbon::parse($item->week_start_date)->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
            return [
                'year' => $item->year,
                'week' => $item->week,
                'week_range' => $startDate->format('Y/m/d') . '〜' . $endDate->format('Y/m/d'),
                'work_type' => $workTypes[$item->work_type_id] ?? '不明',
                'total_minutes' => (int)$item->total_minutes,
            ];
        });

    return response()->json([
        'monthly' => [
            'characters' => $monthlyCharacters,
            'work_times' => $monthlyWorkTime,
        ],
        'weekly' => [
            'characters' => $weeklyCharacters,
            'work_times' => $weeklyWorkTime,
        ],
    ]);
}
}
