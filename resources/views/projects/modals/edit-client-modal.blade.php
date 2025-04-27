<div class="modal fade" id="edit-client-{{ $client->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> クライアント内容変更
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.update', $client->id) }}" method="post">
                    @csrf
                    @method('patch')

                    <input type="text" name="name" id="name" value="{{ old('client',$client->name) }}" placeholder="クライアント名を入力してください" class="form-control mb-2 me-2" autofocus>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="詳細も登録できます">{{ old('client',$client->description) }}</textarea>

                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                    @error('description')
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
