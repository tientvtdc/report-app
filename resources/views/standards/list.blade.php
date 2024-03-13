@extends('layouts.admin')

@section('title', 'Đánh giá')

@section('section')

    <div class="tw-flex-row tw-w-full gap-4 tw-inline-flex">
        <div>
            <a href="{{route('standards.create')}}" class="btn btn-success tw-min-w-[120px] ">Thêm</a>
        </div>
        <div class="input-group tw-items-center ">
            <input type="text" class="form-control" placeholder="Tìm kiếm tiêu chuẩn" aria-label="Recipient's username"
                   aria-describedby="button-addon2">
            <button class="btn btn-outline-primary" type="button" id="button-addon2"><i class="bi bi-search"></i>
            </button>
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
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($standards as $standard)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$standard['code']}}</td>
                    <td>{{$standard['content']}}</td>
                    <td>{{$standard['point']}}</td>
                    <td>{{$standard['created_at']}}</td>
                    <td class="tw-w-[100px]">
                        {{--                        @if($evidence->creator->id === Auth::user()->id || Auth::user()->hasRole('SUPER_ADMIN'))--}}
                        <a href="{{route('standards.edit',['standard' => $standard])}}" class="mx-3">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('standards.destroy', $standard) }}"
                              style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0"
                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        {{--                        @endif--}}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tw-w-full flex-row tw-flex tw-justify-center tw-mt-6">
        {{--        {{ $assessments->links() }}--}}
    </div>
@endsection


