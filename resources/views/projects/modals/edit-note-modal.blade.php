<div class="modal fade" id="edit-note-{{ $note->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> 進捗メモ変更
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.update', $note->id) }}" method="post">
                    @csrf
                    @method('patch')

                    <textarea id="note" name="note" class="form-control" rows="3" placeholder="メモを入力...">{{ old('note',$note->note) }}</textarea>

                    @error('note')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
            </div>
            <div class="modal-footer border-0">

                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">戻る</button>
                    <button type="submit" class="btn btn-warning btn-sm">変更</button>
                </form>
            </div>
        </div>
    </div>
</div>
