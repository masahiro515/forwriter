@extends('layouts.app')

@section('title', '統計サマリー')

@section('content')
<div class="container mt-4 w-75">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h4 class="mb-0">統計サマリー</h4>
        </div>

        <div class="card-body">

            {{-- フィルタフォーム --}}
            <form id="filterForm" class="mb-4 d-flex align-items-center gap-2">
                <label class="me-2 mb-0"><strong>期間:</strong></label>
                <input type="date" name="start" class="form-control form-control-sm w-auto">
                <span class="mx-1">〜</span>
                <input type="date" name="end" required class="form-control form-control-sm w-auto">
                <button type="submit" class="btn btn-sm btn-outline-primary">適用</button>
            </form>

            {{-- 3カラムレイアウト --}}
            <div class="row">
                {{-- 左カラム --}}
                <div class="col-md-4">
                    <h6 class="text-muted">案件情報</h6>
                    <p><strong>案件数:</strong> <span id="projectCount">-</span></p>
                    <p><strong>総報酬額:</strong> <span id="totalSalary">-</span> 円</p>
                </div>

                {{-- 中央カラム --}}
                <div class="col-md-4">
                    <h6 class="text-muted">文字数</h6>
                    <p><strong>総文字数:</strong> <span id="totalCharacters">-</span></p>
                    <p><strong>時間あたり文字数:</strong> <span id="charactersPerHour">-</span></p>
                </div>

                {{-- 右カラム --}}
                <div class="col-md-4">
                    <h6 class="text-muted">作業時間</h6>
                    <p><strong>総作業時間:</strong> <span id="totalMinutes">-</span></p>
                    <p><strong>時給換算:</strong> <span id="hourlyRate">-</span> 円</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <h6 class="text-muted">仕事内容の割合</h6>
            <canvas id="jobTypeChart"></canvas>
        </div>
        <div class="col-md-4">
            <h6 class="text-muted">作業別時間の割合</h6>
            <canvas id="workTypeChart"></canvas>
        </div>
        <div class="col-md-4">
            <h6 class="text-muted">クライアント別案件割合</h6>
            <canvas id="clientChart"></canvas>
        </div>
    </div>

</div>
@endsection

