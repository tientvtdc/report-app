@extends('layouts.admin')

@section('title', 'Thêm tiêu chuẩn mới')

@section('section')
    <div class="row justify-content-start">
        <div class="col-md-9">
            <div class="card rounded">
                <div class="card-header tw-text-xl tw-font-bold">{{ __('Thêm Tiêu Chuẩn') }}</div>
                <div class="card-body">
                    <form action="{{route('standards.create')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="standard_name" class="form-label">Mã tiêu chuẩn</label>
                            <input type="text" class="form-control" id="standard_code" name="standard_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="standard_point" class="form-label">Điểm tiêu chuẩn</label>
                            <input type="number" class="form-control" id="standard_point" name="standard_point"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="standard_description" class="form-label">Mô tả tiêu chuẩn</label>
                            <textarea class="form-control" id="standard_description" name="standard_description"
                                      rows="3"
                                      required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm tiêu chuẩn</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


