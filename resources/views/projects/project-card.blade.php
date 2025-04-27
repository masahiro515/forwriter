<!-- resources/views/components/project-card.blade.php -->

<div class="card mb-2">
    <div class="card-body py-2">
        {{-- タイトルと★ボタン --}}
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h6 class="card-title mb-0">{{ $project->title }}（{{ $project->client->name }}）</h6>
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
        </div>

        {{-- 納期 --}}
        <p class="card-text small text-muted mb-1">納期: {{ $project->deadline }}</p>

        {{-- ステータスとボタン --}}
        <div class="d-flex justify-content-between align-items-center">
            <span class="small">
                ステータス: <span class="badge
                @if ($project->status === '受注') bg-primary
                @elseif ($project->status === '作業中') bg-danger
                @elseif ($project->status === '確認中') bg-warning text-dark
                @elseif ($project->status === '納品') bg-success
                @elseif ($project->status === '完了') bg-secondary
                @else bg-light text-dark
                @endif
                ">
                    {{ $project->status }}
                </span>
            </span>

            <div class="d-flex gap-2"> {{-- gap-2でボタン間に少しスペース --}}
                <a href="#" class="btn btn-sm btn-outline-secondary">詳細</a>
                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#timerModal">
                    タイマー開始
                </button>
            </div>
            @include('projects.modals.timer-modal')
        </div>
    </div>
</div>
