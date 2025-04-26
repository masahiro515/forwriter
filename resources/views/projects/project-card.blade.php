<!-- resources/views/components/project-card.blade.php -->

<div class="card mb-3">
    <div class="card-body">
        <h6 class="card-title">{{ $project->title }}</h6>
        <p class="card-text small text-muted">納期: {{ $project->deadline->format('Y/m/d') }}</p>
        <p class="card-text small">
            ステータス: <span class="badge bg-primary">{{ $project->status }}</span>
        </p>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-outline-secondary">詳細</a>
            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#timerModal">
                タイマー開始
            </button>
            <form method="POST" action="{{ route('projects.togglePickup', $project->id) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm {{ $project->is_pickup ? 'btn-warning' : 'btn-outline-warning' }}">
                    ★
                </button>
            </form>
        </div>
    </div>
</div>
