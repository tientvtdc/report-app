@extends('layouts.admin')

@section('title', 'Đánh giá')

@section('section')

    <div class="flex-row tw-w-full gap-4">
        <a href="{{route('assessments.create')}}" class="btn btn-success">Thêm</a>
    </div>
    <div class="tw-mt-6 p-3 border bg-white rounded">
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Năm học</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Chương trình</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($assessments as $assessment)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$assessment['schoolyear']}}</td>
                    <td>{{$assessment['content']}}</td>
                    <td>{{$assessment['program']['program_vi_title']}}</td>
                    <td>{{$assessment['created_at']}}</td>
                    <td>
                        <a href="#" class="mx-2">
                            <i class="bi bi-download"></i>
                        </a>
                        <a href="{{route('assessments.show',['id' => $assessment['id']])}}" class="mx-2">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tw-w-full flex-row tw-flex tw-justify-center tw-mt-6">
        {{ $assessments->links() }}
    </div>
@endsection


