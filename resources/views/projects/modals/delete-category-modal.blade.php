<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> 仕事内容削除
                </h3>
            </div>
            <div class="modal-body">
                <p class="text-start">仕事内容：<span class="fw-bold">{{ $category->name }}</span>を削除しても大丈夫ですか？</p>
                <p class="text-start"><i class="fa-solid fa-triangle-exclamation text-warning"></i><span class="fw-bold">{{ $category->name }}</span>で登録されている案件も全て削除されます。</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('category.delete', $category->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">戻る</button>
                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
