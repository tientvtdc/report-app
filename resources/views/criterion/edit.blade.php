@extends('layouts.admin')

@section('title', 'Chỉnh sửa Tiêu chí')

@section('section')
    <div class="row justify-content-start">
        <div class="col-md-9">
            <div class="card rounded">
                <div class="card-header tw-text-xl tw-font-bold">{{ __('Chỉnh sửa Minh Chứng') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('criteria.edit', $criterion) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="code">{{ __('Mã Tiêu Chí') }}</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                   id="code" value="{{ old('code',$criterion->code) }}" required>

                            @error('code')
                            <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="content">{{ __('Nội Dung Tiêu Chí') }}</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content"
                                      id="content" required>{{ old('content',$criterion->content) }}</textarea>

                            @error('content')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                           </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 mt-3 tw-pt-6">
                            <button type="submit" class="btn btn-primary tw-min-w-[120px]">{{ __('Cập nhật') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
