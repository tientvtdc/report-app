@extends('layouts.admin')

@section('title', 'Đánh giá')

@section('section')

    @if( Auth::user()->hasRole('SUPER_ADMIN'))
        <div class="flex-row tw-w-full gap-4">
            <a href="{{route('assessments.create')}}" class="btn btn-success">Thêm</a>
        </div>
    @endif

    <div class="tw-mt-6 p-3 border bg-white rounded">
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Năm học</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Chương trình</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col"></th>
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
                        @if( Auth::user()->hasRole('SUPER_ADMIN'))
                            <form method="POST" action="{{ route('assessments.destroy', $assessment) }}"
                                  style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0"
                                        onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <a href="{{route('assessments.clone',[$assessment])}}" class="mx-3">
                                <i class="bi bi-copy"></i>
                            </a>
                        @endif

                        <a
                            class="mx-3" target="_blank"
                            href="{{route('assessments.downloadFileEvidence',['id' => $assessment['id']])}}"
                        >
                            <i class="bi bi-download"></i>
                        </a>

                        <a class="mx-3 "
                           href="{{route('assessments.generatePDF',['id' => $assessment['id']])}}"
                        >
                            <i class="bi bi-printer"></i>
                        </a>
                        <a href="{{route('assessments.show',['id' => $assessment['id']])}}" class="mx-3">
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


