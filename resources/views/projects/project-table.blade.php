@extends('layouts.app')

@section('content')
<div class="container">
    {{-- プロジェクト一覧テーブル --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle small">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>受注日</th>
                    <th>案件名</th>
                    <th>クライアント</th>
                    <th>ステータス</th>
                    <th>仮納期</th>
                    <th>納期</th>
                    <th>仮支払日</th>
                    <th>支払日</th>
                    <th>仮報酬</th>
                    <th>確定報酬</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_projects as $project)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $project->received_date }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->client->name }}</td>
                        <td class="d-flex justify-content-center">
                            <form method="POST" action="{{ route('project.updateStatus', $project->id) }}">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4 d-flex align-items-center">
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
                        </td>
                        <td>{{ $project->temp_deadline }}</td>
                        <td>{{ $project->deadline }}</td>
                        <td>{{ $project->temp_pay_date }}</td>
                        <td>{{ $project->pay_date ?? '-' }}</td>
                        <td>{{ $project->temp_salary }}</td>
                        <td>{{ $project->salary ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('project.show', $project->id) }}" class="btn btn-secondary">詳細</a>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center"> {{-- 横並び & ボタン間に間隔 --}}
                                {{-- ピックアップボタン --}}
                                @if ($project->isPickup())
                                    <form action="{{ route('pickup.delete', $project->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm p-1 btn-warning d-flex justify-content-center align-items-center"
                                            style="width: 25px; height: 25px;">
                                            ★
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('pickup.store', $project->id) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm p-1 btn-outline-warning d-flex justify-content-center align-items-center"
                                            style="width: 25px; height: 25px;">
                                            ☆
                                        </button>
                                    </form>
                                @endif

                                {{-- タイマーボタン --}}
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#timerModal">
                                    <i class="fa-solid fa-clock"></i>
                                </button>
                                @include('projects.modals.timer-modal')

                                {{-- 編集ボタン --}}
                                <a href="{{ route('project.edit', $project->id) }}" class="btn btn-sm btn-outline-warning d-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                {{-- 削除ボタン --}}
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-project-{{ $project->id }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                @include('projects.modals.delete-project-modal')
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center text-muted">該当する案件がありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $all_projects->links() }}
        </div>
    </div>

</div>
@endsection
