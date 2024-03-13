@extends('layouts.admin')

@section('title', 'Tài khoản')

@section('section')
    <div class="d-flex flex-row tw-w-full gap-4">
        <a href="{{route('users.store')}}" class="btn btn-success">Thêm</a>
    </div>
    <div class="tw-mt-6 p-3 border bg-white rounded">
        <table class="table table-sm tw-text-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="tw-w-min-[320px]">Tên tài khoản</th>
                <th scope="col">Email</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$user['name']}}</td>
                    <td>{{$user['email']}}</td>
                    <td class="text-center">{{$user['created_at']}}</td>
                    <td>
                        {{--                        <a href="{{route('users.edit',['id' => $user->id])}}" class="mx-3">--}}
                        {{--                            <i class="bi bi-pencil"></i>--}}
                        {{--                        </a>--}}
                        @if(!$user->hasRole('SUPER_ADMIN'))
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}"
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
@endsection
