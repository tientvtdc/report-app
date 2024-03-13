@extends('layouts.admin')

@section('title', 'Minh chứng')

@section('section')

    <div class="d-flex flex-row tw-w-full gap-4">
        <a href="{{route('evidences.create')}}" class="btn btn-success">Thêm</a>
        <form method="GET" action="{{ route('evidences.index') }}" class="input-group tw-items-center tw-w-full ">
            <input type="text" class="form-control"
                   placeholder="Tìm kiếm minh chứng" value="{{ old('q') }}"
                   name="q">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i>
            </button>
        </form>
    </div>
    <div class="tw-mt-6 p-3 border bg-white rounded">
        <table class="table table-sm tw-text-sm align-text-top">
            <thead>
            <tr class="align-text-top">
                <th scope="col">#</th>
                <th scope="col" class="tw-w-min-[200px]">Tiêu đề</th>
                <th scope="col" class="tw-w-max">Tên Phòng - Khoa - Trung tâm cấp</th>
                <th scope="col">Ngày cấp</th>
                <th scope="col">Hiệu lực</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">File minh chứng</th>
                <th scope="col">Người tạo</th>
                <th scope="col">Note</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($evidences as $evidence)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td class="tw-w-min-[200px]">{{$evidence['title']}}</td>
                    <td>{{$evidence['name_organizations']}}</td>
                    <td>{{$evidence['issued_at']}}</td>
                    <td>
                        @if ($evidence['valid_from'])
                            {{ date('d/m/Y', strtotime($evidence['valid_from'])) }}
                        @endif
                        -
                        @if ($evidence['valid_to'])
                                @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($evidence['valid_to'])))
                                    <span style="color:red;">{{ \Carbon\Carbon::parse($evidence['valid_to'])->format('d/m/Y') }}</span>
                                @else
                                    {{ \Carbon\Carbon::parse($evidence['valid_to'])->format('d/m/Y') }}
                                @endif

                            @endif
                    </td>
                    <td class="text-center">{{$evidence['created_at']}}</td>
                    <td class="tw-max-w-[200px] overflow-x-hidden">
                        <a class="tw-max-w-[200px] tw-cursor-pointer tw-truncate"
                           href="{{ Storage::url($evidence['attachment'])}} "
                            title="{{basename($evidence['attachment'])}}"
                        >
                            {{basename($evidence['attachment'])}}
                        </a>
                    </td>
                    <td>{{$evidence['creator']['name']}}</td>
                    <td class="tw-max-w-[200px]">
                        @if($evidence['editor'])
                            Đã chỉnh sửa bởi {{$evidence['editor']['name']}} lúc {{$evidence['updated_at']}}
                        @endif
                    </td>
                    <td class="tw-w-[150px]">
                        @if($evidence->creator->id === Auth::user()->id || Auth::user()->hasRole('SUPER_ADMIN'))
                            <a href="{{route('evidences.edit',['id' => $evidence->id])}}" class="mx-3">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('evidences.destroy', $evidence->id) }}"
                                  style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0"
                                        onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="tw-w-full flex-row tw-flex tw-justify-center tw-mt-6">
        {{ $evidences->appends(['q' => request()->input('q')])->links() }}
    </div>
@endsection


