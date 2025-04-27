<div class="modal fade" id="delete-project-{{ $project->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> 案件削除
                </h3>
            </div>
            <div class="modal-body">
                <p class="text-start">案件：<span class="fw-bold">{{ $project->title }}</span>を削除しても大丈夫ですか？</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('project.delete', $project->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">戻る</button>
                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
