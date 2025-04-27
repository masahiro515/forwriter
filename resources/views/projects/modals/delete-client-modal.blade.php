<div class="modal fade" id="delete-client-{{ $client->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> クライアント削除
                </h3>
            </div>
            <div class="modal-body">
                <p class="text-start">クライアント：<span class="fw-bold">{{ $client->name }}</span></p>
                <p class="text-start">詳細：{{ $client->description }}</p>
                <p class="text-start">を削除しても大丈夫ですか？</p>
                <p class="text-start"><i class="fa-solid fa-triangle-exclamation text-warning"></i><span class="fw-bold">{{ $client->name }}</span>で登録されている案件も全て削除されます。</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('client.delete', $client->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">戻る</button>
                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
