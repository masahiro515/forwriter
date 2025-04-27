@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')
    <div class="container d-flex justify-content-center"> {{-- 追加した中央寄せの外枠 --}}
        <div class="row w-50">
            <div class="form-group">
                <form action="{{ route('client.store') }}" method="post" class="d-flex">
                    @csrf
                    <div class="w-75">
                        <input type="text" name="name" id="name" placeholder="クライアント名を入力してください" class="form-control" autofocus>
                    </div>
                    <div class="w-25 ms-2">
                        <button type="submit" class="btn btn-primary w-50">
                            登録
                        </button>
                    </div>
                </form>
            </div>
            <div class="form-group mb-1">
                <form action="{{ route('client.store') }}" method="post">
                    @csrf
                    <div>
                        <!-- 非表示のtextarea -->
                        <textarea id="description" name="description" class="form-control mt-1" rows="3" placeholder="詳細も登録できます" style="display:none;"></textarea>
                        <!-- 詳細入力ボタン -->
                        <button type="button" id="toggle-description" class="btn btn-success btn-sm mt-2">
                            詳細入力
                        </button>
                    </div>
                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                    @error('description')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </form>
            </div>
            <table class="table table-hover align-middle bg-white border text-secondary">
                <thead class="small table-success text-secondary">
                    <tr>
                        <th>クライアント名</th>
                        <th>詳細</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->description }}</td>
                            <td class="text-end">
                                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-client-{{ $client->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                @include('projects.modals.edit-client-modal')
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-client-{{ $client->id }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                @include('projects.modals.delete-client-modal')
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>クライアント情報を登録しましょう</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $all_clients->links() }}
            </div>
        </div>
    </div> {{-- containerの閉じタグ --}}

    <script>
        document.getElementById('toggle-description').addEventListener('click', function() {
            var descriptionTextarea = document.getElementById('description');
            // 詳細入力欄の表示・非表示を切り替える
            if (descriptionTextarea.style.display === 'none' || descriptionTextarea.style.display === '') {
                descriptionTextarea.style.display = 'block';
            } else {
                descriptionTextarea.style.display = 'none';
            }
        });
    </script>
@endsection






