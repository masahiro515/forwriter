@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="row justify-content-center w-50">
        <div class="col-md-12">
            <div class="card shadow-sm p-4" style="border-radius: 15px;">
                <h3 class="text-center mb-4">案件編集フォーム</h3>

                <div class="card-body">
                    <form action="{{ route('project.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            {{-- Title --}}
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">案件名</label>
                                <input id="title" type="text" name="title" class="form-control" maxlength="50" value="{{ old('title',$project->title) }}" placeholder="案件タイトルを入力">
                                @error('title')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">案件詳細</label>
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="案件の詳細を入力">{{ old('description',$project->description) }}</textarea>
                                @error('description')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Received Date --}}
                            <div class="col-md-6 mb-3">
                                <label for="received_date" class="form-label">受注日</label>
                                <input id="received_date" type="date" name="received_date" class="form-control" value="{{ old('received_date',$project->received_date) }}">
                                @error('received_date')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Temp Pay Date --}}
                            <div class="col-md-6 mb-3">
                                <label for="temp_pay_date" class="form-label">振込予定日</label>
                                <input id="temp_pay_date" type="date" name="temp_pay_date" value="{{ old('temp_pay_date',$project->temp_pay_date) }}" class="form-control">
                                @error('temp_pay_date')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Temp Deadline --}}
                            <div class="col-md-6 mb-3">
                                <label for="temp_deadline" class="form-label">目標納期</label>
                                <input id="temp_deadline" type="date" name="temp_deadline" value="{{ old('temp_deadline',$project->temp_deadline) }}" class="form-control">
                                @error('temp_deadline')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deadline --}}
                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="form-label">契約納期</label>
                                <input id="deadline" type="date" name="deadline" value="{{ old('deadline',$project->deadline) }}" class="form-control">
                                @error('deadline')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Cost per Character --}}
                            <div class="col-md-6 mb-3">
                                <label for="cost_per_character" class="form-label">文字単価</label>
                                <input id="cost_per_character" type="number" name="cost_per_character" value="{{ old('cost_per_character',$project->cost_per_character) }}" class="form-control" placeholder="例：1">
                                @error('cost_per_character')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deadline Character --}}
                            <div class="col-md-6 mb-3">
                                <label for="deadline_character" class="form-label">指定文字数</label>
                                <input id="deadline_character" type="number" name="deadline_character" value="{{ old('deadline_character',$project->deadline_character) }}" class="form-control">
                                @error('deadline_character')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Temp Salary --}}
                            <div class="col-md-6 mb-3">
                                <label for="temp_salary" class="form-label">振込予定金額</label>
                                <input id="temp_salary" type="number" name="temp_salary" value="{{ old('temp_salary',$project->temp_salary) }}" class="form-control">
                                @error('temp_salary')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Client ID --}}
                            <div class="col-md-6 mb-3">
                                <label for="client_id" class="form-label">クライアント選択</label>
                                @if ($all_clients->isNotEmpty())
                                    <select id="client_id" name="client_id" class="form-select">
                                        @foreach ($all_clients as $client)
                                            @if ($project->client_id == $client->id)
                                                <option value="{{ $client->id }}" selected>{{ $client->name }}</option>
                                            @else
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <a href="{{ route('client.create') }}" class="d-block mt-2 text-decoration-none">クライアントを登録する</a>
                                @endif

                                @error('client_id')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category ID + Submit --}}
                            <div class="col-md-6 mb-4">
                                <label for="category_id" class="form-label">仕事内容選択</label>
                                @if ($all_categories->isNotEmpty())
                                    <select id="category_id" name="category_id" class="form-select">
                                        @foreach ($all_categories as $category)
                                            @if ($project->category_id == $category->id)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <a href="{{ route('category.create') }}" class="d-block mt-2 text-decoration-none">仕事内容を登録する</a>
                                @endif

                                @error('category_id')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4" style="margin-top:30px;">
                                <div class="row g-2">
                                    <div class="col-6 d-grid">
                                        <a href="{{ route('project.show', $project->id) }}" class="btn btn-outline-warning form-control">
                                            戻る
                                        </a>
                                    </div>
                                    <div class="col-6 d-grid">
                                        <input type="hidden" name="status" value="受注">
                                        <button type="submit" class="btn btn-warning form-control">
                                            変更
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
