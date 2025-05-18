@extends('layouts.app')

@section('title','notes')

@section('content')

<div class="container w-50">
    {{-- 進捗メモ一覧 --}}
    <div class="d-flex align-items-center gap-3 mb-3">
        <a href="{{ route('project.show', $project_id) }}" class="btn btn-outline-secondary">戻る</a>
        <h4 class="mb-0">進捗メモ</h4>
    </div>

    <div class="list-group mb-4">
        @forelse($all_notes as $note)
            <div class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto" style="flex: 1 1 auto; min-width: 0;">
                    <p class="mb-1 text-break" style="white-space: pre-wrap;">{{ $note->note }}</p>
                    <small class="text-muted">
                        作成: {{ $note->created_at->format('Y/m/d H:i') }} / 更新: {{ $note->updated_at->format('Y/m/d H:i') }}
                    </small>
                </div>
                <div class="d-flex ms-auto gap-2" style="min-width: 120px;">
                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-note-{{ $note->id }}">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    @include('projects.modals.edit-note-modal')

                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-note-{{ $note->id }}">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                    @include('projects.modals.delete-note-modal')
                </div>
            </div>

        @empty
            <p class="text-muted">進捗メモはまだありません。</p>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $all_notes->links() }}
    </div>

    {{-- 追加フォーム --}}
    <h5>新しい進捗を追加</h5>
    <form action="{{ route('notes.store', $project_id) }}" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="#">
        <div class="mb-3">
            <textarea name="note" class="form-control" rows="3" placeholder="メモを入力..." required>{{ old('note') }}</textarea>
            @error('note')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">追加</button>
    </form>
</div>
@endsection

