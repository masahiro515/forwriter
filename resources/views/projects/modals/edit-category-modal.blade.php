<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> 仕事内容変更
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('category.update', $category->id) }}" method="post">
                    @csrf
                    @method('patch')
                        <input type="text" name="category" id="category" value="{{ old('category',$category->name) }}" placeholder="仕事内容を入力してください" class="form-control">
                        @error('category')
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
