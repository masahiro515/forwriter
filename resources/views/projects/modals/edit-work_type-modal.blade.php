<div class="modal fade" id="edit-work_type-{{ $work_type->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> 作業内容変更
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('workType.update', $work_type->id) }}" method="post">
                    @csrf
                    @method('patch')
                        <input type="text" name="work_type" id="work_type" value="{{ old('work_type',$work_type->name) }}" placeholder="仕事内容を入力してください" class="form-control">
                        @error('work_type')
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
