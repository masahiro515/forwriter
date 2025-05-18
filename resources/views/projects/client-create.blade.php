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
            </div>
            <div class="form-group mb-1">
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
                        <th style="width: 25%;">クライアント名</th>
                        <th style="width: 55%;">詳細</th>
                        <th style="width: 20%; text-align: right;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>
                                <div class="description-preview" style="max-height: 4.5em; overflow: hidden; position: relative;" id="desc-{{ $client->id }}">
                                    {{ $client->description }}
                                </div>
                                @if(Str::length($client->description) > 100)
                                    <button class="btn btn-link p-0" onclick="toggleDescription({{ $client->id }})" id="btn-{{ $client->id }}">続きを読む</button>
                                @endif
                            </td>
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
                            <td colspan="3" class="text-center">クライアント情報を登録しましょう</td>
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

        function toggleDescription(id) {
            const desc = document.getElementById(`desc-${id}`);
            const btn = document.getElementById(`btn-${id}`);

            if (desc.style.maxHeight && desc.style.maxHeight !== 'none') {
                desc.style.maxHeight = 'none';
                btn.textContent = '閉じる';
            } else {
                desc.style.maxHeight = '4.5em'; // 約3行
                btn.textContent = '続きを読む';
            }
        }
    </script>
@endsection






