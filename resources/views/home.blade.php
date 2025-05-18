<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 90vh; overflow: hidden;">
        <!-- 左カラム（ピックアップ案件） -->
        <div class="col-md-4 border-end" style="overflow-y: auto;">
            <h5 class="mt-3">ピックアップ案件</h5>
            @foreach ($pickup_projects as $project)
                @include('projects.project-card')
            @endforeach
        </div>

        <!-- 中央カラム（ステータス別） -->
        <div class="col-md-4" style="overflow-y: auto;">
            <h5 class="mt-3">{{ $startOfMonth->format('Y年n月') }}受注案件</h5>
            <!-- ステータスフィルター -->
            <div class="mb-3">
                <form method="GET" action="{{ route('home') }}">
                    <select name="status" onchange="this.form.submit()" class="form-select">
                        <option value="">すべてのステータス</option>
                        <option value="受注" {{ request('status') == '受注' ? 'selected' : '' }}>受注</option>
                        <option value="作業中" {{ request('status') == '作業中' ? 'selected' : '' }}>作業中</option>
                        <option value="確認中" {{ request('status') == '確認中' ? 'selected' : '' }}>確認中</option>
                        <option value="納品" {{ request('status') == '納品' ? 'selected' : '' }}>納品</option>
                        <option value="完了" {{ request('status') == '完了' ? 'selected' : '' }}>完了</option>
                        <!-- 他ステータス追加可 -->
                    </select>
                </form>
            </div>

            @foreach ($all_projects as $project)
                @if (request('status') === null || $project->status === request('status'))
                    @include('projects.project-card', ['project' => $project])
                @endif
            @endforeach
        </div>

        <!-- 右カラム（納期が近い順） -->
        <div class="col-md-4 border-start" style="overflow-y: auto;">
            <h5 class="mt-3">納期が近い案件</h5>
            @foreach ($order_deadline_projects as $project)
                @include('projects.project-card')
            @endforeach
        </div>
    </div>
</div>
@endsection

