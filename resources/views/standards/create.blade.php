@extends('layouts.admin')

@section('title', 'Thêm tiêu chuẩn mới')

@section('section')
    <h1>Thêm tiêu chuẩn mới</h1>
    <form action="{{route('standards.create')}}" method="post">
        <div class="mb-3">
            <label for="standard_name" class="form-label">Mã tiêu chuẩn</label>
            <input type="text" class="form-control" id="standard_code" name="standard_code" required>
        </div>
        <div class="mb-3">
            <label for="standard_point" class="form-label">Điểm tiêu chuẩn</label>
            <input type="number" class="form-control" id="standard_point" name="standard_point" required>
        </div>
        <div class="mb-3">
            <label for="standard_description" class="form-label">Mô tả tiêu chuẩn</label>
            <textarea class="form-control" id="standard_description" name="standard_description" rows="3"
                      required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm tiêu chuẩn</button>
    </form>
@endsection


