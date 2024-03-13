@extends('layouts.admin')

@section('title', 'Tiêu chí')

@section('section')

    <div class="d-flex flex-row tw-w-full gap-4">
        <a href="{{route('criteria.create')}}" class="btn btn-success">Thêm</a>
    </div>
    <div class="tw-mt-6 p-3 border bg-white rounded">
        <table class="table table-sm tw-text-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="tw-w-min-[320px]">Mã</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col"> </th>
            </tr>
            </thead>
            <tbody>

            @foreach ($criteria as $criterion)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$criterion['code']}}</td>
                    <td>{{$criterion['content']}}</td>
                    <td class="text-center">{{$criterion['created_at']}}</td>
                    <td>
                        {{--                        @if($evidence->creator->id === Auth::user()->id || Auth::user()->hasRole('SUPER_ADMIN'))--}}
                        <a href="{{route('criteria.edit',$criterion)}}" class="mx-3">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('criteria.destroy', $criterion->id) }}"
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
        {{ $criteria->appends(['q' => request()->input('q')])->links() }}
    </div>
@endsection


