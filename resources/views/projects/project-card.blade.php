<!-- resources/views/components/project-card.blade.php -->

<div class="card mb-2">
    <div class="card-body py-2">
        {{-- タイトルと★ボタン --}}
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h6 class="card-title mb-0">{{ $project->title }}（{{ $project->client->name }}）</h6>
            <form method="POST" action="#" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm p-1 {{ $project->is_pickup ? 'btn-warning' : 'btn-outline-warning' }}">
                    ★
                </button>
            </form>
        </div>

        {{-- 納期 --}}
        <p class="card-text small text-muted mb-1">納期: {{ $project->deadline }}</p>

        {{-- ステータスとボタン --}}
        <div class="d-flex justify-content-between align-items-center">
            <span class="small">
                ステータス: <span class="badge bg-primary">{{ $project->status }}</span>
            </span>

            <div class="d-flex gap-2"> {{-- gap-2でボタン間に少しスペース --}}
                <a href="#" class="btn btn-sm btn-outline-secondary">詳細</a>
                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#timerModal">
                    タイマー開始
                </button>
            </div>
        </div>
    </div>
</div>
