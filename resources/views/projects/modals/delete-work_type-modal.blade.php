<div class="modal fade" id="delete-work_type-{{ $work_type->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> 作業内容削除
                </h3>
            </div>
            <div class="modal-body">
                <p class="text-start">作業内容：<span class="fw-bold">{{ $work_type->name }}</span>を削除しても大丈夫ですか？</p>
                <p class="text-start"><i class="fa-solid fa-triangle-exclamation text-warning"></i><span class="fw-bold">{{ $work_type->name }}</span>で記録したデータが全て削除されます。</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('workType.delete', $work_type->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">戻る</button>
                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
