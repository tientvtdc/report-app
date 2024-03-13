@extends('layouts.admin')

@section('title', 'Cập Nhật Tiêu Chuẩn')

@section('section')
    <div class="row justify-content-start">
        <div class="col-md-9">
            <div class="card rounded">
                <div class="card-header tw-text-xl tw-font-bold">{{ __('Cập Nhật Tiêu Chuẩn') }}</div>
                <div class="card-body">
                    <form action="{{route('standards.update', $standard)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="standard_name" class="form-label">Mã tiêu chuẩn</label>
                            <input type="text" class="form-control" id="standard_code" name="code"
                                   value="{{ old('code', $standard->code) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="standard_point" class="form-label">Điểm tiêu chuẩn</label>
                            <input type="number" class="form-control" id="standard_point" name="point"
                                   value="{{ old('point', $standard->point) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="standard_description" class="form-label">Mô tả tiêu chuẩn</label>
                            <textarea class="form-control" id="standard_description" name="content" rows="3"
                                      required>{{ old('content', $standard->content) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
