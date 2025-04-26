<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 90vh; overflow: hidden;">
        <!-- 左カラム（ピックアップ案件） -->
        <div class="col-md-4 border-end" style="overflow-y: auto;">
            <h5 class="mt-3">ピックアップ案件</h5>
            {{-- @foreach ($pickupProjects as $project)
                @include('projects.project-card', ['project' => $project])
            @endforeach --}}
        </div>

        <!-- 中央カラム（ステータス別） -->
        <div class="col-md-4" style="overflow-y: auto;">
            <h5 class="mt-3">ステータス別案件</h5>
            <!-- ステータスフィルター -->
            <div class="mb-3">
                <form method="GET" action="{{ route('home') }}">
                    <select name="status" onchange="this.form.submit()" class="form-select">
                        <option value="">すべてのステータス</option>
                        <option value="作業中" {{ request('status') == '作業中' ? 'selected' : '' }}>作業中</option>
                        <option value="完了" {{ request('status') == '完了' ? 'selected' : '' }}>完了</option>
                        <!-- 他ステータス追加可 -->
                    </select>
                </form>
            </div>

            {{-- @foreach ($statusProjects as $project)
                @include('projects.project-card', ['project' => $project])
            @endforeach --}}
        </div>

        <!-- 右カラム（納期が近い順） -->
        <div class="col-md-4 border-start" style="overflow-y: auto;">
            <h5 class="mt-3">納期が近い案件</h5>
            {{-- @foreach ($nearDeadlineProjects as $project)
                @include('projects.project-card', ['project' => $project])
            @endforeach --}}
        </div>
    </div>
</div>

<!-- タイマーモーダル（ここで共通モーダル定義） -->
<div class="modal fade" id="timerModal" tabindex="-1" aria-labelledby="timerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timerModalLabel">作業タイマー開始</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>
      <div class="modal-body">
        <p>ここにタイマー起動処理を追加します。</p>
      </div>
    </div>
  </div>
</div>
@endsection

