@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="container mt-4 w-75">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                {{ $project->title }}（{{ $project->client->name }}）
            </h4>

            <div class="d-flex align-items-center">
                {{-- ピックアップボタン --}}
                @if ($project->isPickup())
                    <form action="{{ route('pickup.delete', $project->id) }}" method="post" class="d-inline me-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm p-1 btn-warning d-flex justify-content-center align-items-center"
                            style="width: 25px; height: 25px;">
                            ★
                        </button>
                    </form>
                @else
                    <form action="{{ route('pickup.store', $project->id) }}" method="post" class="d-inline me-1">
                        @csrf
                        <button type="submit" class="btn btn-sm p-1 btn-outline-warning d-flex justify-content-center align-items-center"
                            style="width: 25px; height: 25px;">
                            ☆
                        </button>
                    </form>
                @endif

                <div class="d-flex gap-2 me-1"> {{-- gap-2でボタン間に少しスペース --}}
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#timerModal">
                        <i class="fa-solid fa-clock"></i>
                    </button>
                </div>
                @include('projects.modals.timer-modal')

                {{-- 編集ボタン --}}
                <a href="{{ route('project.edit', $project->id) }}" class="btn btn-sm btn-outline-warning d-flex justify-content-center align-items-center me-1"
                    style="width: 30px; height: 30px;">
                    <i class="fa-solid fa-pen"></i>
                </a>
                {{-- @include('projects.modals.edit-project-modal') --}}

                {{-- 削除ボタン --}}
                <button class="btn btn-sm btn-outline-danger d-flex justify-content-center align-items-center"
                    style="width: 30px; height: 30px;"
                    data-bs-toggle="modal" data-bs-target="#delete-project-{{ $project->id }}">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
                @include('projects.modals.delete-project-modal')
            </div>
        </div>

        <div class="card-body">

            {{-- ステータス（選択式） --}}
            <form method="POST" action="{{ route('project.updateStatus', $project->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4 d-flex align-items-center">
                    <strong class="me-2">ステータス:</strong>
                    <select name="status" class="form-select form-select-sm w-auto
                        @if ($project->status === '受注') bg-primary text-white
                        @elseif ($project->status === '作業中') bg-danger text-white
                        @elseif ($project->status === '確認中') bg-warning text-dark
                        @elseif ($project->status === '納品') bg-success text-white
                        @elseif ($project->status === '完了') bg-secondary text-white
                        @else bg-light text-dark
                        @endif
                    " onchange="this.form.submit()">
                        @foreach (['受注', '作業中', '確認中', '納品', '完了'] as $status)
                            <option value="{{ $status }}" {{ $project->status == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            {{-- 3カラムレイアウト --}}
            <div class="row">
                {{-- 左カラム --}}
                <div class="col-md-4">
                    <h6 class="text-muted">納期関連</h6>
                    <p><strong>受注日:</strong> {{ $project->received_date }}</p>
                    <p><strong>仮納期:</strong> {{ $project->temp_deadline ?? '未設定' }}</p>
                    <p><strong>納期:</strong> {{ $project->deadline }}</p>
                    <p><strong>仮支払日:</strong> {{ $project->temp_pay_date ?? '未設定' }}</p>

                    {{-- 支払日（編集可能） --}}
                    <form method="POST" action="{{ route('project.updatePayDate', $project->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="d-flex align-items-center mb-2">
                            <strong class="me-2">支払日:</strong>
                            <input type="date" name="pay_date" value="{{ $project->pay_date }}" class="form-control form-control-sm w-auto"
                                onchange="this.form.submit()">
                        </div>
                    </form>
                </div>

                {{-- 中央カラム --}}
                <div class="col-md-4">
                    <h6 class="text-muted">文字数・給与</h6>
                    <p><strong>文字単価:</strong> {{ $project->cost_per_character ? number_format($project->cost_per_character) . ' 円' : '未設定' }}</p>
                    <p><strong>納品予定文字数:</strong> {{ $project->deadline_character ?? '未設定' }}</p>
                    <p><strong>仮給与:</strong> {{ $project->temp_salary ? number_format($project->temp_salary) . ' 円' : '未設定' }}</p>

                    {{-- 確定給与（編集可能） --}}
                    <form method="POST" action="{{ route('project.updateSalary', $project->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex align-items-center mb-2">
                            <strong class="me-2">確定給与:</strong>
                            <input type="number" name="salary" value="{{ $project->salary }}" class="form-control form-control-sm w-auto"
                                onchange="this.form.submit()">
                            <span class="ms-1">円</span>
                        </div>
                    </form>

                    {{-- 総文字数（編集可能） --}}
                    <form method="POST" action="{{ route('project.updateTotalCharacters', $project->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex align-items-center mb-2">
                            <strong class="me-2">総文字数:</strong>
                            <input type="number" name="total_characters" value="{{ $project->total_characters }}" class="form-control form-control-sm w-auto"
                                onchange="this.form.submit()">
                        </div>
                    </form>
                </div>

                {{-- 右カラム --}}
                <div class="col-md-4">
                    <h6 class="text-muted">作業情報</h6>
                    <form method="GET" action="{{ route('project.show', $project->id) }}">
                        <p>
                            <select name="work_type_id" onchange="this.form.submit()" class="form-select d-inline w-auto">
                                <option value="" {{ request('work_type_id') ? '' : 'selected' }}>時間を確認する作業を選んでください</option>
                                @foreach($all_work_types as $type)
                                    <option value="{{ $type->id }}" {{ request('work_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if(request('work_type_id'))
                                <p>{{ formatMinutes($workingMinutes) }}</p>
                            @endif
                        </p>
                    </form>
                    <p><strong>総作業時間:</strong> {{ formatMinutes($totalMinutes) }}</p>

                    <h6 class="text-muted mt-3">案件詳細</h6>
                    <div class="border p-2 bg-light small">
                        {{ $project->description ?? '説明はありません。' }}
                    </div>
                </div>
            </div>

            {{-- 登録・更新日時 --}}
            <div class="text-end text-muted small mt-4">
                登録日: {{ $project->created_at->format('Y-m-d H:i') }} /
                更新日: {{ $project->updated_at->format('Y-m-d H:i') }}
            </div>

            {{-- 戻るボタン --}}
            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">一覧に戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection

