@extends('layouts.admin')

@section('title', 'Đánh giá')

@section('section')

    <div class="tw-flex-row tw-w-full gap-4 tw-inline-flex">
        <div>
            <a href="{{route('standards.create')}}" class="btn btn-success tw-min-w-[120px] ">Thêm</a>
        </div>
        <div class="input-group tw-items-center ">
            <input type="text" class="form-control" placeholder="Tìm kiếm tiêu chuẩn" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-primary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
    </div>
    <div class="tw-mt-6 p-3 border bg-white rounded">
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Điểm</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
{{--            @foreach ($assessments as $assessment)--}}
{{--                <tr>--}}
{{--                    <th scope="row">{{ $loop->iteration }}</th>--}}
{{--                    <td>{{$assessment['schoolyear']}}</td>--}}
{{--                    <td>{{$assessment['content']}}</td>--}}
{{--                    <td>{{$assessment['program']['program_vi_title']}}</td>--}}
{{--                    <td>{{$assessment['created_at']}}</td>--}}
{{--                    <td>--}}
{{--                        <a href="#">--}}
{{--                            <i class="bi bi-download"></i>--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}

            </tbody>
        </table>
    </div>
    <div class="tw-w-full flex-row tw-flex tw-justify-center tw-mt-6">
{{--        {{ $assessments->links() }}--}}
    </div>
@endsection


