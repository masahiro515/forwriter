@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')
    <div class="container d-flex justify-content-center"> {{-- 追加した中央寄せの外枠 --}}
        <div class="row w-25">
            <div class="form-group mb-2">
                <form action="{{ route('category.store') }}" method="post" class="d-flex">
                    @csrf
                    <input type="text" name="category" id="category" placeholder="仕事内容を入力してください" class="form-control me-2" autofocus>
                    <button type="submit" class="btn btn-primary" style="min-width: 55px;">
                        登録
                    </button>
                    @error('category')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </form>
            </div>
            <table class="table table-hover align-middle bg-white border text-secondary">
                <thead class="small table-warning text-secondary">
                    <tr>
                        <th>仕事内容</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td class="text-end">
                                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                @include('projects.modals.edit-category-modal')
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                @include('projects.modals.delete-category-modal')
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>仕事内容を登録しましょう</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $all_categories->links() }}
            </div>
        </div>
    </div> {{-- containerの閉じタグ --}}
@endsection

