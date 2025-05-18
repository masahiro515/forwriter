<div class="modal fade" id="delete-note-{{ $note->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> 進捗メモ削除
                </h3>
            </div>
            <div class="modal-body">
                <p class="text-start">進捗メモ：<span class="fw-bold">{{ $note->note }}</span></p>
                <p class="text-start">を削除しても大丈夫ですか？</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('notes.delete', $note->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">戻る</button>
                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
